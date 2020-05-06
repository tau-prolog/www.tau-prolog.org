<div class="white container-fluid py-5">
    <div class="container">
		<h1>Making your own packages</h1>
		<p>A package is a series of Prolog modules that export a set of predicates. Tau Prolog offers some modules for working with lists, manipulating the DOM, obtaining statistics, etc. This page describes how to create these packages.</p>
	</div>
</div>

<div class="white container-fluid py-5">
    <div class="container">
		<h2 id="structure"><a href="#structure">Structure of a package</a></h2>
		<p>A package is a JavaScript file that introduces one or more modules. A module is characterized by a name, a set of predicates, and a list of predicates to export. The structure is as follows:</p>
		<pre class="highlight javascript highlight-javascript"><code>var pl;
(function( pl ) {
	// Name of the module
	var name = "my_module";
	// Object with the set of predicates, indexed by indicators (name/arity)
	var predicates = function() {
		return {
			// p/1
			"p/1": [ /** ... */ ],
			// q/2
			"q/2": function(thread, point, atom) { /** ... */ }
		};
	};
	// List of predicates exported by the module
	var exports = ["p/1", "q/2" /** , ... */];
	// DON'T EDIT
	if( typeof module !== 'undefined' ) {
		module.exports = function(tau_prolog) {
			pl = tau_prolog;
			new pl.type.Module( name, predicates(), exports );
		};
	} else {
		new pl.type.Module( name, predicates(), exports );
	}
})( pl );</code></pre>
		<p>As you can see from the code above, predicates are not defined directly as an object, but as a function that returns that object. This is because when working with Node.js, the global <code>pl</code> object containing all Tau Prolog functionality is not available when declaring predicates. In this way, the module can be imported both in Node.js and in the browser without any problem. For the same reason, it is necessary to declare (without assigning any value) the variable <code>pl</code> in the first line of the file.</p>
		<p>To load the package, just load this file on the page or in Node.js as if it were any other Tau Prolog package, and enter the directive <code>:- use_module(library(my_module)).</code> in the program to import the predicates of a module.</p>

		<h2 id="predicates" class="mt-5"><a href="#predicates">Definition of predicates</a></h2>
		<p>There are two ways to define a predicate:</p>
		<ul>
			<li>As a list of Prolog clauses: <br /><code>[ /** ... */ ]</code></li>
			<li>As a JavaScript function that receives the thread of execution, the current point of choice, and the selected atom: <br /><code>function(thread, point, atom) { /** ... */ }</code></li>
		</ul>

		<h3 class="mt-5">Defining predicates as Prolog clauses</h3>
		<p>To define a predicate as a Prolog clause, you must use the internal representation of the objects defined by Tau Prolog. For example, the predicate <code>p/1</code> formed by the following clause, <code>p(X) :- q(X, X).</code> would be expressed as follows:</p>
		<pre class="highlight javascript highlight-javascript"><code>"p/1": [
	new pl.type.Rule(
		new pl.type.Term("p", [new pl.type.Var("X")]),
		new pl.type.Term("q", [new pl.type.Var("X"), new pl.type.Var("X")])
	)
]</code></pre>
		<p>Manually writing a Prolog predicate in this way can be tedious, so Tau Prolog objects include a <code>compile</code> method to automatically generate this code. Therefore, to obtain this representation, you only have to load the Prolog program in one session, and print the compiled code through the standard output:</p>
		<pre class="highlight javascript highlight-javascript"><code>var session = pl.create();
session.consult("p(X) :- q(X, X).");
console.log(session.compile());
// {"p/1": [new pl.type.Rule(new pl.type.Term("p", [new pl.type.Var("X")]), new pl.type.Term("q", [new pl.type.Var("X"),new pl.type.Var("X")]))]};</code></pre>
		<h3 class="mt-5">Defining predicates as JavaScript functions</h3>
		<p>Sometimes it is necessary to resort to JavaScript to implement some functionality, either because it is not possible to do it directly from Prolog, or for efficiency reasons. Therefore, a predicate can also be defined as a JavaScript function that directly manipulates the thread's choice point stack. This function receives as parameters:</p>
		<ul>
			<li>the thread of execution,</li>
			<li>the current choice point,</li>
			<li>and the selected atom of the current goal, that is, the leftmost atom of that goal.</li>
		</ul>
		<p>A common scheme when implementing these functions is to obtain the arguments of the selected atom, check if there are any errors (instantiation, type, domain, etc.) and, if necessary, manipulate the choice point stack. For example, the following function in the <code>random</code> module implements the <code>random/3</code> predicate, which generates a random number between two given numbers:</p>
<pre class="highlight javascript highlight-javascript"><code>"random/3": function( thread, point, atom ) {
	var lower = atom.args[0], upper = atom.args[1], rand = atom.args[2];
	if( pl.type.is_variable( lower ) || pl.type.is_variable( upper ) ) {
		thread.throw_error( pl.error.instantiation( atom.indicator ) );
	} else if( !pl.type.is_number( lower ) ) {
		thread.throw_error( pl.error.type( "number", lower, atom.indicator ) );
	} else if( !pl.type.is_number( upper ) ) {
		thread.throw_error( pl.error.type( "number", upper, atom.indicator ) );
	} else if( !pl.type.is_variable( rand ) && !pl.type.is_number( rand ) ) {
		thread.throw_error( pl.error.type( "number", rand, atom.indicator ) );
	} else {
		if( lower.value < upper.value ) {
			var float = lower.is_float || upper.is_float;
			var gen = lower.value + Math.random() * (upper.value - lower.value);
			if( !float )
				gen = Math.floor( gen );
			thread.prepend( [new pl.type.State(
				point.goal.replace( new pl.type.Term( "=", [rand, new pl.type.Num( gen, float )] ) ),
				point.substitution,
				point 
			)] );
		}
	}
}</code></pre>
		<p>In the first line of this function, the arguments of the selected atom are collected in the variables <code>lower</code>, <code>upper</code> and <code>rand</code>. The first two arguments are then verified to be non-variable using the <code>pl.type.is_variable</code> function. If either is a variable, an error is thrown using the <code>Thread.prototype.throw_error</code> function, generated by the <code>pl.error.instantiation</code> function. Similarly, the type of the arguments is checked below, and an error is thrown if applicable.</p>
		<p>If everything is correct, a random number is generated between the two given numbers and a new choice point is inserted. The <code>Thread.prototype.prepend</code> function receives an array of states and inserts them to the beginning of the choice point stack. A state receives three values: a goal, a substitution, and the reference to the parent state. Typically, the new goal is generated by replacing the selected atom in the current goal with another term, and for that there is the <code>Term.prototype.replace</code> function. Instead of generating the most general unifier and modifying the substitution directly, it is recommended to replace the selected atom with a term of the form <code>argument = value</code> in the new goal.</p>
		<p>It is also often the case that when a predicate is successful you simply have to insert a state where the selected atom must be removed, without inserting a new term, and without modifying the substitution. For example, the <code>maybe/0</code> predicate of the <code>random</code> package.</p>
		<pre class="highlight javascript highlight-javascript"><code>"maybe/0": function( thread, point, _ ) {
	if( Math.random() < 0.5 ) {
		thread.success( point );
	}
}</code></pre>
		<p>This is done using the <code>Thread.prototype.success</code> function, which adds a new state to the top of the choice point stack where the selected atom is removed. The same can be accomplished by inserting a state with the <code>prepend</code> function, replacing the selected atom with <code>null</code>, and leaving the substitution unchanged.</p>
		<p class="manual-warning"><b>Note</b>: It is important that the functions that implement these predicates do not return any value. As we will see later, returning a value that evaluates to <code>true</code> instead of <code>undefined</code> would indicate to Tau Prolog that the function is asynchronous. <b>For a predicate to NOT be successful, simply insert no new state in the choice point stack.</b></p>

		<h2 id="async-predicates" class="mt-5"><a href="#async-predicates">Definition of asynchronous predicates</a></h2>
		<p>Some predicates implemented as JavaScript functions require the use of asynchronous functions. For example, the following <code>sleep/1</code> predicate in the Tau Prolog <code>system</code> module sleeps the thread for a few seconds.</p>
<pre class="highlight javascript highlight-javascript"><code>"sleep/1": function( thread, point, atom ) {
	var time = atom.args[0];
	if( pl.type.is_variable( time ) ) {
		thread.throw_error( pl.error.instantiation( thread.level ) );
	} else if( !pl.type.is_integer( time ) ) {
		thread.throw_error( pl.error.type( "integer", time, thread.level ) );
	} else {
		setTimeout( function() {
			thread.success( point );
			thread.again();
		}, time.value );
		return true;
	}
}</code></pre>
		<p>If there is no error, the <code>sleep/1</code> predicate uses the <code>setTimeout</code> function to perform an action after a few seconds, and returns the value <code>true</code> (only in case the function is to succeed). This tells Tau Prolog that an asynchronous predicate has been run, and that it should no longer apply resolution steps, as the predicate itself will reactivate the inference process at some point. In the case of <code>sleep/1</code>, after a few seconds, a new choice point is inserted into the stack, and the <code>Thread.prototype.again</code> method is invoked so that the inference resumes.</p>
	</div>
</div>