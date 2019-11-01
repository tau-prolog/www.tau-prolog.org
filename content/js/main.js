var try_program = "";
var try_goal = "";
var try_goals = [""];
var try_stack = 0;
var session = null;
var code = null;
var query = null;

// Codemirror
window.addEventListener("load", function() {
	code = CodeMirror(document.getElementById("try-program"), {
		value: ":- use_module(library(lists)).",
		lineNumbers: true,
		theme: "tau",
		placeholder: "Your program here...",
		mode: "prolog"
	});
	query = CodeMirror(document.getElementById("try-goal"), {
		lineNumbers: false,
		theme: "tauout",
		placeholder: "Type a Prolog goal in here and press ENTER",
		mode: "prolog"
	});
	code.setSize("100%", "100%");
	query.setSize("100%", query.defaultTextHeight() + 2 * 4);
	query.on("beforeChange", function(instance, change) {
		var newtext = change.text.join("").replace(/\n/g, "");
		change.update(change.from, change.to, [newtext]);
		return true;
	});
	query.on("keyHandled", try_tau_prolog);
	var version = document.getElementById("tau-version");
	if(version != null) {
		version.innerHTML = pl.version.major + "." +  pl.version.minor + "." + pl.version.patch;
	}
});

function try_tau_prolog( cm, msg, e ) {
	// Down
	if( e.keyCode === 40 ) {
		try_stack++;
		if( try_stack >= try_goals.length ) try_stack = 0;
		document.getElementById( "try-goal" ).value = try_goals[try_stack];
	// Up
	} else if( e.keyCode === 38 ) {
		try_stack--;
		if( try_stack < 0 ) try_stack = try_goals.length - 1;
		document.getElementById( "try-goal" ).value = try_goals[try_stack];
	// Enter
	} else if( e.keyCode === 13 ) {
		var raw_program = code.getValue();
		var raw_goal = query.getValue();
		if( try_program !== raw_program || try_goal !== raw_goal ) {
			try_goals.push( raw_goal );
			try_stack = try_goals.length - 1;
			session = pl.create(10000);
			var c = session.consult( raw_program );
			var q = session.query( raw_goal );
			if( c !== true ) {
				try_answer( 'error parsing program: ' + c.args[0], true );
				return;
			}
			if( q !== true ) {
				try_answer( 'error parsing query: ' + q.args[0], true );
				return;
			}
		}
		session.answer( try_answer );
	}
	try_program = raw_program;
	try_goal = raw_goal;
}

function try_answer( answer, format ) {
	if( document.getElementById( "try-description" ) ) {
		document.getElementById( "try-answers" ).innerHTML = "";
		document.getElementById( "try-answers" ).style.height = "200px";
	}
	var inner = document.getElementById( "try-answers" ).innerHTML;
	if( inner !== "" ) {
		document.getElementById( "try-answers" ).innerHTML = "<div class=\"try-sep\"></div>" + inner;
	}
	document.getElementById( "try-answers" ).innerHTML = "<div class=\"try-answer\">" + (format ? answer : pl.format_answer( answer, session )) + "</div>" + document.getElementById( "try-answers" ).innerHTML;	
}

function show_implementation( module, predicate ) {
	var code = "";
	if( module === "builtin" ) {
		code = pl.predicate[predicate].toString().replace( /^\t\t\t/gm, "" );
	} else {
		var ref = pl.module[module].rules[predicate];
		if( ref instanceof Function ) {
			code = ref.toString().replace( /^\t\t\t/gm, "" );
		} else if( ref instanceof Array ) {
			for( var p in ref ) {
				var p = ref[p];
				code += p.toString() + "\n";
			}
		} else if( ref instanceof String ) {
			show_implementation( module, ref );
			return;
		}
	}
	document.getElementById("code-implementation").innerHTML = code;
}

function show_prototype( func, ref ) {
	var code = func.toString().replace( /^\t/gm, "" );
	var last = document.getElementById("code_prototype");
	var li = null;
	if( last ) {
		li = last.parentNode;
		last.parentNode.removeChild( last );
	}
	if( ref.parentNode == li )
		return;
	code = "<pre id=\"code_prototype\" class=\"highlight\"><code>" + code + "</pre></code>";
	ref.parentNode.innerHTML = ref.parentNode.innerHTML + code;
	hljs.highlightBlock(document.getElementById("code_prototype"));
}

function submit_change( checkbox ) {
	if( checkbox.checked ) {
		document.getElementById( "submit_b" ).disabled = false; 
	} else {
		document.getElementById( "submit_b" ).disabled = true; 
	}
}
