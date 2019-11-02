<?php

$predicate = $_GET["predicate"];
$arity = $_GET["arity"];
$slug = $_GET["package"];
$info = query_predicate( $slug, $predicate, $arity );
$templates = query_templates( $info["id"] );
$examples = query_predicate_examples( $info["id"] );
$related = query_predicates_by_category( $info["category"] );

?>

<div class="white container-fluid py-5">
    <div class="container">
        <h1><?php echo show_predicate_name( $predicate ) . "/$arity"; ?></h1>
        <h4 class="text-secondary"><?php echo show_description( $info["short_description"] ); ?></h4>
	</div>
</div>

<div class="white container-fluid py-5">
    <div class="container">
        <h2 class="mb-4">Description</h2>
<?php
// Templates
foreach( $templates as $template ) {
	echo show_template( $template );
}
// Description
echo show_description( $info["long_description"] );
?>
	</div>
</div>

<?php if( count( $examples ) > 0 ) { ?>
<div class="yellow container-fluid py-5">
    <div class="container">
        <h2 class="mb-4">Examples</h2>
<?php
$i = 0;
foreach( $examples as $example ) {
	$i++;
	echo show_example( $example, $i, "prolog" );
}
?>
	</div>
</div>

<?php } ?>

<div class="purple container-fluid py-5">
    <div class="container">
        <h2 class="mb-4">Implementation</h2>
		<pre class="highlight"><code id="code-implementation"></code></pre>
		<script type="text/javascript"><?php echo "show_implementation( '$slug', '$predicate/$arity' );"; ?></script>
    </div>
</div>