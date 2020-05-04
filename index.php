<?php

// requires
require( "content/php/mysql.php" );
require( "content/php/functions.php" );

// download
if( isset( $_POST['download'] ) && $_POST['download'] == 'custom' ) {
	
	$_view = 'custom';
	$nodejs = $_POST["nodejs"] == 1;
	$_modules = [];
		if( $_POST['core'] ) $_modules[] = 'core';
		if( $_POST['lists'] ) $_modules[] = 'lists';
		if( $_POST['random'] ) $_modules[] = 'random';
		if( $_POST['statistics'] ) $_modules[] = 'statistics';
		if( $_POST['dom'] ) $_modules[] = 'dom';
		if( $_POST['js'] ) $_modules[] = 'js';
	// Node.js support
	if( $nodejs ) {
		$file = tempnam("tmp", "zip");
		$zip = new ZipArchive();
		$zip->open($file, ZipArchive::OVERWRITE);
		$zip->addFile("code/license.txt", "license.txt");
		foreach( $_modules as $m ) {
			$zip->addFile("code/$m-latest.js", "$m.js");
		}
		$zip->close();
		header('Content-Type: application/zip');
		header('Content-Length: ' . filesize($file));
		header('Content-Disposition: attachment; filename="file.zip"');
		readfile($file);
		unlink($file);
	} else {
		header( "Content-type: text/javascript" );
		echo file_get_contents( "code/license.js" );
		foreach( $_modules as $m ) {
			echo file_get_contents( "code/$m-latest.js" );
		}
	}
	
} else {
	
	// page
	if( isset( $_GET["view"] ) ) {
		$_view = $_GET["view"];
	} else {
		$_view = "home";
	}
	if( !file_exists( "content/php/pages/$_view.php" ) ) {
		$_view = "404";
		header( "HTTP/1.0 404 Not Found" );
	}
	if( $_link->connect_errno ){
		$_view = "mysql";
	}

	if( isset( $_GET['package'] ) ) $_GET['package'] = $_link->escape_string( $_GET['package'] );
	if( isset( $_GET['predicate'] ) ) $_GET['predicate'] = str_replace( ' ', '+', $_link->escape_string( $_GET['predicate'] ) );
	
}


include( "content/php/headers/default.php" );
if( $_view == "examples" )
	include( "content/php/headers/examples/" . $_GET["example"] . ".php" );
if( file_exists( "content/php/headers/$_view.php" ) ) {
	include( "content/php/headers/$_view.php" );
}

if( $_view != 'custom') {

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Tau Prolog: <?php echo $_title; ?></title>
		<meta name="description" content="Tau Prolog: <?php echo $_description; ?>" />
		<meta name="author" content="José Antonio Riaza Valverde" />
		<meta name="keywords" content="Prolog, JavaScript, Interpreter, Logic, Programming">
		<meta charset="UTF-8" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
		<link href="/content/img/favicon.ico" type="image/x-icon" rel="icon" />
		<link rel="StyleSheet" href="/content/css/highlight.css" type="text/css" media="ALL" />
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<!-- Tau Prolog modules -->
		<script type="text/javascript" src="/code/core-latest.js"></script>
		<script type="text/javascript" src="/code/lists-latest.js"></script>
		<script type="text/javascript" src="/code/random-latest.js"></script>
		<script type="text/javascript" src="/code/statistics-latest.js"></script>
		<script type="text/javascript" src="/code/dom-latest.js"></script>
		<script type="text/javascript" src="/code/system-latest.js"></script>
		<script type="text/javascript" src="/code/js-latest.js"></script>
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<!-- Font Awesome -->
		<script src="https://kit.fontawesome.com/f8cf35179e.js" crossorigin="anonymous"></script>
		<!-- Highlight.js -->
		<script type="text/javascript" src="/content/js/highlight.js"></script>
		<!-- Codemirror -->
		<script src="/content/js/codemirror/lib/codemirror.js"></script>
		<link rel="stylesheet" href="/content/css/codemirror/codemirror.css">
		<link rel="stylesheet" href="/content/css/codemirror/tau.css">
		<link rel="stylesheet" href="/content/css/codemirror/tauout.css">
		<script src="/content/js/codemirror/addon/mode/simple.js"></script>
		<script src="/content/js/codemirror/mode/prolog/prolog.js"></script>
		<script src="/content/js/codemirror/addon/placeholder/placeholder.js"></script>
		<!-- Highlight -->
		<script>hljs.initHighlightingOnLoad();</script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111278071-1"></script>
		<!-- main -->
		<script type="text/javascript" src="/content/js/main.js"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-111278071-1');
		</script>
		<!-- Tau Prolog styles -->
		<link rel="StyleSheet" href="/content/css/main.css" type="text/css" media="ALL" />
	</head>
	<body>
		<div class="container-fluid overflow-hidden py-3" id="navigation">
			<?php if($_view != "home") { ?> <a id="navigation-logo" class="float-left" href="/"></a> <?php } ?>
			<ul class="float-right list-unstyled mb-0">
				<li class="ml-3 float-right"><a id="navigation-link-sandbox" class="p-2 btn btn-success" href="/sandbox" title="Test your Prolog online with Tau Prolog code editor">Sandbox</a></li>
				<li class="ml-3 float-right"><a id="navigation-link-collaborate" class="p-2" href="/collaborate" title="Collaborate">Collaborate</a></li>
				<li class="ml-3 float-right"><a id="navigation-link-documentaiton" class="p-2" href="/documentation" title="Documentation">Documentation</a></li>
				<li class="ml-3 float-right"><a id="navigation-link-downloads" class="p-2" href="/downloads" title="Downloads">Downloads</a></li>
			</ul>
		</div>
<?php if($_view != "home") { ?>
	<div id="header-less" class="purple container-fluid overflow-hidden py-3">
		<div class="container">
			<?php echo show_header( $_header ); ?>
		</div>
	</div>
<?php } ?>
		<?php include("content/php/pages/$_view.php"); ?>
		<div class="container-fluid overflow-hidden py-5" id="footer">
			<div class="container">
				<div class="row">
    				<div class="col-sm">
						<ul class="list-unstyled">
							<li class="font-weight-bold">Community</li>
							<li><a href="http://tau-prolog.org">Site</a></li>
							<li><a href="https://twitter.com/tau_prolog" target="_blank">Twitter</a></li>
							<li><a href="https://github.com/tau-prolog" target="_blank">Github</a></li>
							<li><a href="https://www.npmjs.com/tau-prolog" target="_blank">npm</a></li>
						</ul>
					</div>
					<div class="col-sm">
						<ul class="list-unstyled">
							<li class="font-weight-bold">Documentation</li>
							<li><a href="http://tau-prolog.org/documentation#manual">Manual</a></li>
							<li><a href="http://tau-prolog.org/documentation#examples">Examples</a></li>
							<li><a href="http://tau-prolog.org/documentation#implementation">Implementation details</a></li>
							<li><a href="http://tau-prolog.org/documentation#prolog">Prolog Predicate Reference</a></li>
						</ul>
					</div>
					<div class="col-sm">
						<ul class="list-unstyled">
							<li class="font-weight-bold">Code</li>
							<li><a href="http://tau-prolog.org/downloads#custom">Custom bundle</a></li>
							<li><a href="http://tau-prolog.org/downloads#npm">Installation from npm</a></li>
							<li><a href="http://tau-prolog.org/downloads#source">Source Code</a></li>
						</ul>
					</div>
					<div class="col-sm">
						<ul class="list-unstyled">
							<li class="font-weight-bold">Contact</li>
							<li><a href="http://tau-prolog.org/collaborate#contact">Form contact</a></li>
							<li><a href="http://tau-prolog.org/collaborate#collaborators">Collaborators</a></li>
							<li><a href="http://tau-prolog.org/collaborate#contributors">Contributors</a></li>
							<li><a href="mailto:tau.prolog@gmail.com">tau.prolog @ gmail.com</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="footer-line"></div>
			<div id="footer-logo"></div>
			<div class="overflow-hidden" id="footer-copy">
				<div class="float-left" id="footer-author">&copy 2017 - <?php echo date("Y"); ?> <a href="http://jariaza.es">José Antonio Riaza Valverde</a></div>
				<div clasS="float-right" id="footer-license">Released under the <a href="http://tau-prolog.org/license">BSD-3 Clause license</a></div>
			</div>
		</div>
	</body>
</html>

<?php } $_link->close(); ?>
