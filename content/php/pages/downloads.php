<div class="white container-fluid py-5">
    <div class="container">
        <h1>Downloads</h1>
	</div>
</div>

<div class="purple container-fluid py-5" id="custom">
    <div class="container">
		<h2 class="mb-4">Custom package</h2>
		<p>You can download a custom bundle including only the modules you need. <b>Note that <i>core</i> includes the resolution mechanism and all built-in predicates.</b></p>
		<form action="/tau-prolog.js" method="post">
			<input type="hidden" name="download" value="custom" />
			<div class="overflow-hidden">
				<div class="float-left ml-3 mb-3 font-weight-bold"><input type="checkbox" id="core" name="core" value="core" checked /> <label for="core">Core</label></div>
<?php

foreach(query_modules() as $module) {
	if( $module["slug"] != "builtin" && $module["visible"] ) {
		echo "<div class=\"float-left ml-3 mb-3 font-weight-bold\"><input type=\"checkbox\" id=\"$module[slug]\" name=\"$module[slug]\" value=\"$module[slug]\" checked /> <label for=\"$module[slug]\">$module[name]</label></div>";
	}
}

?>
			</div>
			<div class="downloads-nodejs">
				<input type="checkbox" id="nodejs" name="nodejs" value="1" /> <label for="nodejs" class="font-weight-bold">Download for Node.js</label>
				<p>This option generates a <code>.zip</code> file containing a <code>.js</code> file for each selected module instead of an only <code>.js</code> file with all the code. See <a href="/manual/compatibility-with-nodejs">[Compatibility with Node.js]</a> from Tau Prolog manual for more information.</p>
			</div>
			<input type="submit" id="downloads-button-custom" class="btn btn-lg" value="Download" />
        </form>
    </div>
</div>

<div class="yellow container-fluid py-5" id="npm">
    <div class="container">
		<h2 class="mb-4">Installation using the npm registry</h2>
		<p>You can install Tau Prolog from <a href="https://www.npmjs.com/" target="_blank">npm</a>, which is common practice when using <a href="https://nodejs.org/en/" target="_blank">Node.js</a>:</p>
		<div class="home-brief-look-code">$ npm install tau-prolog</div>
    </div>
</div>

<div class="pink container-fluid py-5" id="source">
    <div class="container">
		<h2 class="mb-4">Source code</h2>
		<p>You can find the source code of Tau Prolog on <a href="https://github.com/tau-prolog/" target="_blank">GitHub</a>:</p>
		<div class="look-code">$ git clone https://github.com/tau-prolog/tau-prolog.git</div>
    </div>
</div>

<div class="white container-fluid py-5" id="logo">
    <div class="container">
		<h2>Logos and icons</h2>
		<p class="font-weight-bold">Do not just include the graphic from our servers on your page, please. Copy the image to your site.</p>
		<div class="mt-4 row">
            <div class="col-md">
                <p class="text-center"><img src="http://tau-prolog.org/logo/tau64.png" alt="Tau Prolog tau logo" title="Tau Prolog tau logo" /></p>
                <p>
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau.svg">SVG format</a>
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau16.png">PNG x16</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau32.png">PNG x32</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau64.png">PNG x64</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau128.png">PNG x128</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau256.png">PNG x256</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tau512.png">PNG x512</a>
                </p>
            </div>
            <div class="col-md">
                <p class="text-center"><img src="http://tau-prolog.org/logo/tauprolog64.png" alt="Tau Prolog complete logo" title="Tau Prolog complete logo" /></p>
                <p>
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog.svg">SVG format</a>
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog16.png">PNG x16</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog32.png">PNG x32</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog64.png">PNG x64</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog128.png">PNG x128</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog256.png">PNG x256</a> 
                    <a class="btn btn-sm mr-1 mb-2" href="http://tau-prolog.org/logo/tauprolog512.png">PNG x512</a>
                </p>
            </div>
		</div>
	</div>	
</div>
