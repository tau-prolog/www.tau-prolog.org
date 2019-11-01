<div class="match-width manual">
	<h2>Compilación y desarrollo de módulos</h2>
	<p>En esta página se describe cómo implementar predicados y programas. Tau Prolog ofrece la posibilidad de compilar un programa Prolog, generando el código JavaScript necesario que puede ser almacenado y cargado como un módulo.</p>
	
	<h3 id="compilacion"><a href="#compilacion">Compilación de programas Prolog</a></h3>
	
	<p>La forma más sencilla de generar un módulo en Tau Prolog es cargar el programa en una sesión, y utilizar el método <span class="inline-code">compile</span> del prototipo <span class="inline-code">pl.type.Session</span>. Este método se encarga de generar y devolver una cadena de caracteres con el código JavaScript necesario, que puede ser directamente copiado y pegado en un fichero <span class="inline-code">.js</span> y cargado en la página.</p>
	
	<pre class="highlight"><code>var session = pl.create();
session.consult(
	"append([], X, X)." +
	"append([H|T], X, [H|S]) :- append(T, X, S)." +
	"member(X, [X|_])." +
	"member(X, [_|Xs]) :- member(X, Xs)."
);
console.log(session.compile()); // '{"append/3": [new pl.type.Rule(new pl.type.Term("append", [new pl.type.Term("[]", []),new pl.type.Var("X"),new pl.type.Var("X")]), null),new pl.type.Rule(new pl.type.Term("append", [new pl.type.Term(".", [new pl.type.Var("H"),new pl.type.Var("T")]),new pl.type.Var("X"),new pl.type.Term(".", [new pl.type.Var("H"),new pl.type.Var("S")])]), new pl.type.Term("append", [new pl.type.Var("T"),new pl.type.Var("X"),new pl.type.Var("S")]))],"member/2": [new pl.type.Rule(new pl.type.Term("member", [new pl.type.Var("X"),new pl.type.Term(".", [new pl.type.Var("X"),new pl.type.Var("_")])]), null),new pl.type.Rule(new pl.type.Term("member", [new pl.type.Var("X"),new pl.type.Term(".", [new pl.type.Var("_"),new pl.type.Var("Xs")])]), new pl.type.Term("member", [new pl.type.Var("X"),new pl.type.Var("Xs")]))]};'
</code></pre>
	
	<p>El resultado del método <span class="inline-code">compile</span> nos proporciona un objeto con todas las reglas de la sesión. En este caso el objeto tiene dos propiedades, <span class="inline-code">append/3</span> y <span class="inline-code">member/2</span>, las cuales contienen la lista de reglas que definen los predicados:</p>
	
	<pre class="highlight"><code>{
	"append/3": [
		new pl.type.Rule(new pl.type.Term("append", [new pl.type.Term("[]", []),new pl.type.Var("X"),new pl.type.Var("X")]), null),
		new pl.type.Rule(new pl.type.Term("append", [new pl.type.Term(".", [new pl.type.Var("H"),new pl.type.Var("T")]),new pl.type.Var("X"),new pl.type.Term(".", [new pl.type.Var("H"),new pl.type.Var("S")])]), new pl.type.Term("append", [new pl.type.Var("T"),new pl.type.Var("X"),new pl.type.Var("S")]))
	],
		
	"member/2": [
		new pl.type.Rule(new pl.type.Term("member", [new pl.type.Var("X"),new pl.type.Term(".", [new pl.type.Var("X"),new pl.type.Var("_")])]), null),
		new pl.type.Rule(new pl.type.Term("member", [new pl.type.Var("X"),new pl.type.Term(".", [new pl.type.Var("_"),new pl.type.Var("Xs")])]), new pl.type.Term("member", [new pl.type.Var("X"),new pl.type.Var("Xs")]))
	]
};</code></pre>
	
	<h3 id="modulos"><a href="#modulos">Generación de módulos</a></h3>
	
	<h3 id="predicados-extralogicos"><a href="#predicados-extralogicos">Predicados extralógicos</a></h3>
	
	<h3 id="predicados-asincronos"><a href="#predicados-asincronos">Predicados asíncronos</a></h3>
	
</div>
