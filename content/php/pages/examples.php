<div class="white container-fluid py-5">
    <div class="container">
        <h1><?php echo $_example_name; ?></h1>
        <h4 class="text-secondary"><?php echo $_example_description; ?></h4>
	</div>
</div>

<div class="white container-fluid py-5">
    <div class="container">
        <h2 class="mb-4">Run example</h2>
        <?php include("content/examples/" . $_GET["example"] . ".html"); ?>
	</div>
</div>

<div class="yellow container-fluid py-5">
    <div class="container">
        <h2 class="mb-4">Souce code</h2>
        <div class="look-code"><?php echo htmlspecialchars(file_get_contents("content/examples/" . $_GET["example"] . ".html")); ?></div>
	</div>
</div>