<?php

$show = isset($_GET["show"]) && $_GET["show"] == "all";

?>

<div class="white container-fluid py-5">
    <div class="container">
        <h1>Documentation</h1>
	</div>
</div>

<div class="purple container-fluid py-5" id="manual">
	<div class="container">
		<h2 class="mb-4">Get Started with Tau Prolog</h2>
		<ul class="list-unstyled">
			<li class="mb-2 p-2 border"><i class="fas fa-book mr-1"></i> <a href="/manual/a-simple-tutorial"><b>A simple tutorial</b></a> <a href="/manual/a-simple-tutorial" class="btn btn-sm ml-2 py-0 float-right">EN</a> <a href="/manual/es/un-tutorial-sencillo" class="btn btn-sm ml-2 py-0 float-right">ES</a></li>
			<li class="mb-2 p-2 border"><i class="fas fa-book mr-1"></i> <a href="/manual/compatibility-with-nodejs"><b>Compatibility with Node.js</b></a> <a href="/manual/compatibility-with-nodejs" class="btn btn-sm ml-2 py-0 float-right">EN</a> <a href="/manual/es/compatibilidad-con-nodejs" class="btn btn-sm ml-2 py-0 float-right">ES</a></li>
			<li class="mb-2 p-2 border"><i class="fas fa-book mr-1"></i> <a href="/manual/manipulating-the-dom-with-prolog"><b>Manipulating the DOM with Prolog</b></a> <a href="/manual/manipulating-the-dom-with-prolog" class="btn btn-sm ml-2 py-0 float-right">EN</a> <a href="/manual/es/manipulando-el-dom-con-prolog" class="btn btn-sm ml-2 py-0 float-right">ES</a></li>
			<li class="mb-2 p-2 border"><i class="fas fa-book mr-1"></i> <a href="/manual/making-your-own-packages"><b>Making your own packages</b></a> <a href="/manual/making-your-own-packages" class="btn btn-sm ml-2 py-0 float-right">EN</a> <a href="/manual/es/creando-tus-propios-paquetes" class="btn btn-sm ml-2 py-0 float-right">ES</a></li>
			<li class="p-2 border"><i class="fas fa-book mr-1"></i> <a href="/manual/prototypes-and-prolog-objects"><b>Prototypes and Prolog objects</b></a> <a href="/manual/prototypes-and-prolog-objects" class="btn btn-sm ml-2 py-0 float-right">EN</a> <a href="/manual/es/prototipos-y-objetos-prolog" class="btn btn-sm ml-2 py-0 float-right">ES</a></li>
		</ul>
	</div>
</div>

<div class="pink container-fluid py-4">
    <div class="container text-center">
        <a href="#prolog" class="btn btn-lg mr-2 my-2">Prolog Predicate Reference</a>
        <a href="#examples" class="btn btn-lg mr-2 my-2">Examples</a>
        <a href="#implementation" class="btn btn-lg mr-2 my-2">Implementation details</a>
        <a href="#articles" class="btn btn-lg mr-2 my-2">Related articles</a>
        <a href="#references" class="btn btn-lg mr-2 my-2">References</a>
	</div>
</div>

<div class="white container-fluid py-5" id="prolog">
	<div class="container">     
        <h2 class="mb-4">Prolog Predicate Reference</h2>
<?php
// Prolog reference
$predicates = query_predicates();

foreach( $predicates as $slug => $package ) {
    echo "<a href=\"#$slug\" class=\"btn btn-lg mr-2 mt-2\"><i class=\"fas fa-cube\"></i> $package[name]</a>";
}

foreach( $predicates as $slug => $package ) {
	echo "<h3 id=\"$slug\" class=\"mt-5\"><a href=\"#$slug\">$package[name]</a></h3>";
	if( $slug != "builtin" ) echo "<div class=\"yellow\"><div class=\"look-code mb-3 ml-0\">:- use_module(library($slug)).</div></div>";
	
	foreach( $package["predicates"]["categories"] as $category => $predicates ) {
		echo "<h5>$category</h5>";
		echo "<ul>";
		foreach( $predicates as $predicate ) {
			echo "<li><a class=\"link-predicate\" href=\"/documentation/prolog/$slug/" . show_predicate_uri( $predicate["name"] ) . "/$predicate[arity]\">" . show_predicate_name( $predicate["name"] ) . "/$predicate[arity]</a> &#8211; " . show_description( $predicate["short_description"] ) . "</li>";
		}
		echo "</ul>";
	}
}
?>
    </div>
</div>

<div class="white container-fluid py-5" id="examples">
	<div class="container">
        <h2 class="mb-4">Examples</h2>
        <div class="row">
            <!-- likes example -->
            <div class="col-sm-4">
            <div class="purple card float-left">
                <img class="card-img-top" style="height:150px;" src="/content/img/examples/likes.png" alt="Likes">
                <div class="card-body">
                    <h5 class="card-title">Likes</h5>
                    <p class="card-text">Use Prolog code to extract information from a Prolog database.</p>
                    <a href="/examples/likes" class="btn btn-block btn-dark">See example</a>
                </div>
            </div>
            </div>
            <!-- doge example -->
            <div class="col-sm-4">
            <div class="purple card float-left">
                <img class="card-img-top" style="height:150px;" src="/content/img/examples/doge.gif" alt="My little doge">
                <div class="card-body">
                    <h5 class="card-title">My little doge</h5>
                    <p class="card-text">Add a playable doge manipulating the DOM with Prolog.</p>
                    <a href="/examples/my-little-doge" class="btn btn-block btn-dark">See example</a>
                </div>
            </div>
            </div>
            <!-- knight example -->
            <div class="col-sm-4">
            <div class="purple card float-left">
                <img class="card-img-top" style="height:150px;" src="/content/img/examples/knights.gif" alt="Knight's tour">
                <div class="card-body">
                    <h5 class="card-title">Knight's tour</h5>
                    <p class="card-text">Simulate the Knight's tour problem exploring all the paths.</p>
                    <a href="/examples/knights-tour" class="btn btn-block btn-dark">See example</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="pink container-fluid py-5" id="implementation">
	<div class="container"> 
        <h2 class="mb-4">Implementation details</h2>
        <ul class="list-unstyled">
            <li class="mb-2 p-2 border"><i class="fas fa-cog mr-2"></i> <a target="_blank" href="http://tau-prolog.org/files/doc/grammar-specification.pdf" title="In this document, we describe the full Prolog grammar specification used by Tau Prolog to parse Prolog code." class="font-weight-bold">Grammar specification</a>
                <span class="font-italic">(Last revision: June 11, 2018)</span>
                <br /> Old versions: <a target="_blank" href="http://tau-prolog.org/files/doc/grammar-specification-may-31-2018.pdf" title="">[May 31, 2018]</a></li>
        </ul>
    </div>
</div>

<div class="purple container-fluid py-5" id="articles">
	<div class="container"> 
        <h2 class="mb-4">Related articles</h2>
        <ul class="list-unstyled">
            <li class="mb-2 p-2 border"><i class="fas fa-newspaper mr-2"></i> <a href="http://blog.klipse.tech/prolog/2019/01/01/blog-prolog.html" target="_blank" class="font-weight-bold">A new way of blogging about Prolog</a> by <a href="http://blog.klipse.tech/" target="_blanks" class="font-weight-bold">Yehonathan Sharvit</a> at <a href="http://blog.klipse.tech/" target="_blank" class="font-weight-bold">KLIPSE</a></li>
            <li class="mb-2 p-2 border"><i class="fas fa-newspaper mr-2"></i> <a href="http://phpmagazine.net/2018/11/tau-prolog-a-prolog-interpreter-fully-in-javascript.html" target="_blank" class="font-weight-bold">Tau Prolog, a Prolog interpreter fully in JavaScript</a> by <a href="http://phpmagazine.net/author/hatemben" target="_blank" class="font-weight-bold"><b>Hatem Ben Yacoub</b></a> at <a href="http://phpmagazine.net/" target="_blank" class="font-weight-bold">PHP Magazine</a></li>
            <li class="mb-2 p-2 border"><i class="fas fa-newspaper mr-2"></i> <a href="https://beta.observablehq.com/@mbostock/hello-tau-prolog" target="_blank" class="font-weight-bold">Hello, Tau Prolog!</a> by <a href="https://beta.observablehq.com/@mbostock" target="_blank" class="font-weight-bold">Mike Bostock</a> at <a href="https://beta.observablehq.com/" target="_blank" class="font-weight-bold">Observable</a></li>
            <li class="mb-2 p-2 border"><i class="fas fa-newspaper mr-2"></i> <a href="https://prologhub.pl/hello-tau-prolog/" target="_blank" class="font-weight-bold">Hello, Tau Prolog!</a> by <a href="https://prologhub.pl/?author=pbmagi" target="_blank" class="font-weight-bold">Paul Brown</a> at <a href="https://prologhub.pl" target="_blank" class="font-weight-bold">PrologHub</a></li>
        </ul>
    </div>
</div>

<div class="yellow container-fluid py-5" id="references">
	<div class="container"> 
        <h2 class="mb-4">References</h2>
        <ul class="list-unstyled">
            <li class="mb-2 p-2 border"><i class="fas fa-asterisk mr-2"></i> <a target="_blank" href="https://www.iso.org/standard/21413.html" class="font-weight-bold">ISO/IEC 13211-1:1995</a></li>
            <li class="mb-2 p-2 border"><i class="fas fa-asterisk mr-2"></i> <a target="_blank" href="http://fsl.cs.illinois.edu/images/9/9c/PrologStandard.pdf" class="font-weight-bold">ISO Prolog: A Summary of the Draft Proposed Standard</a> by <span class="font-weight-bold">M. A. Covington</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-asterisk mr-2"></i><a target="_blank" href="http://www.deransart.fr/prolog/bips.html" class="font-weight-bold">ISO directives, control constructs and builtins</a> by <span class="font-weight-bold">J. P. E. Hodgson</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-asterisk mr-2"></i> <a target="_blank" href="http://www.complang.tuwien.ac.at/ulrich/iso-prolog/conformity_testing" class="font-weight-bold">ISO Prolog Conformity Testing</a> by <span class="font-weight-bold">U. Neumerkel</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-asterisk mr-2"></i> <a target="_blank" href="/files/doc/dcgsdin140324JPEH.pdf" class="font-weight-bold">ISO/IEC DTR 13211-3:2006 Definite clause grammar rules</a> by <span class="font-weight-bold">P. Moura</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-asterisk mr-2"></i> <a target="_blank" href="https://www.metalevel.at/prolog" class="font-weight-bold">The Power of Prolog</a> by <span class="font-weight-bold">M. Triska</span></li>
        </ul>
    </div>
</div>