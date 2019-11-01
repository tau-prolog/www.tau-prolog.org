<div class="white container-fluid py-5" id="home-intro">
    <div class="container">
        <div class="row">
    		<div class="col-2-xl text-center">
                <h1 class="font-weight-bold"><img src="/content/img/logo/navigation-tau.png" alt="Tau" /> Tau Prolog</h1>
                <h2 class="font-weight-light text-secondary">An open source Prolog interpreter in JavaScript</h2>
            </div>
            <div class="col-xl pl-3 overflow-hidden">
                <a id="home-get-started" href="/manual/a-simple-tutorial" class="btn btn-lg float-right">Get started</a>
                <div id="home-version" class="text-secondary float-right">Version <span id="tau-version"></div></div>
            </div>
        </div>
    </div>
</div>

<section class="purple container-fluid py-5" id="home-try-it">
    <div class="container">
        <h2 class="mb-4">Try it</h2>
        <div class="row">
    		<div class="col-lg my-3">
                <div id="try-program"></div>
                <div type="text" id="try-goal"></div>
            </div>
            <div class="col-lg my-3 overflow-hidden" id="try-answers">
                <div id="try-description">
                    <p class="text-justify">Paste your program in the box in the left and type a Prolog goal below. When you press <kbd>ENTER</kbd> on the goal textbox, the interpreter will read the goal and try to find a computed answer, showing the result here. If you press <kbd>ENTER</kbd> again (to keep looking for answers), the interpreter will continue looking from the last choice point.</p>
				    <p class="text-justify">Look at <a href="/documentation">built-in predicates and modules</a> supported by Tau Prolog.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pink container-fluid py-5" id="home-a-brief-look">
    <div class="container">
        <h2 class="mb-4">Features</h2>
        <div class="row">
    		<div class="col-xl text-center">
                <!--<div class="home-features-icon"><i class="fas fa-ruler"></i></div>-->
                <h4 class="my-3">ISO Prolog Standard compliance</h4>
                <p class="text-justify">Tau Prolog development has been directed by the ISO Prolog Standard, designed to promote the applicability and portability of Prolog text and data among several data processing systems.</p>
                <a href="https://www.iso.org/standard/21413.html" target="_blank" class="btn btn-block">More about ISO Prolog Standard</a>
            </div>
            <div class="col-xl text-center">
                <!--<div class="home-features-icon"><i class="fab fa-node-js"></i></div>-->
                <h4 class="my-3">Compatible with browsers and Node.js</h4>
                <p class="text-justify">Tau Prolog has been developed to be used with either Node.js or a browser seamlessly. Just use the <code>&lt;script&gt;</code> tag or the <code>require</code> function to add Tau Prolog to your project and start coding.</p>
                <a href="/manual/compatibility-with-nodejs" class="btn btn-block">More about Node.js support</a>
            </div>
            <div class="col-xl text-center">
                <!--<div class="home-features-icon"><i class="fas fa-project-diagram"></i></div>-->
                <h4 class="my-3">DOM manipulation and event handling</h4>
                <p class="text-justify">Taking the best from JavaScript and Prolog, Tau Prolog allows you to handle browser events and modify the DOM of a web using Prolog predicates, making Prolog even more powerful.</p>
                <a href="/manual/manipulating-the-dom-with-prolog" class="btn btn-block">More about DOM and events</a>
            </div>
    		<div class="col-xl text-center">
                <!--<div class="home-features-icon"><i class="fas fa-sync"></i></div>-->
                <h4 class="my-3">Asynchronous predicates</h4>
                <p class="text-justify"> Tau Prolog has been developed following a non-blocking, callback-based approach, allowing you, for instance, to sleep the main thread or to do AJAX requests without blocking the browser.</p>
                <a href="#" class="btn btn-block">More about asynchrony</a>
            </div>
        </div>
	</div>
</section>

<div class="yellow container-fluid py-5" id="home-a-brief-look">
    <div class="container">
        <h2 class="mb-3">A brief look</h2>
        <h4 class="mt-4"><i class="fas fa-dice-one"></i> Load the library</h4>
        <div class="look-code">&lt;script src="tau-prolog.js">&lt;/script></div>

        <h4 class="mt-4"><i class="fas fa-dice-two"></i> Consult a program</h4>
        <div class="look-code">&lt;script id="likes.pl" type="text/prolog">
    likes(sam, salad).
    likes(dean, pie).
    likes(sam, apples).
    likes(dean, whiskey).
&lt;/script></div>
        <div class="mt-3 look-code">var session = pl.create();
session.consult("likes.pl");</div>

        <h4 class="mt-4"><i class="fas fa-dice-three"></i> Query a goal</h4>
        <div class="look-code">session.query("likes(sam, X).");</div>

        <h4 class="mt-4"><i class="fas fa-dice-four"></i> Look for answers</h4>
        <div class="look-code">var callback = console.log;
session.answer(callback); // X = salad ;
session.answer(callback); // X = apples ;
session.answer(callback); // false.</div>

        <h4 class="mt-4"><i class="fas fa-dice-five"></i> Enjoy Prolog!</h4>
        <div class="look-code">// is that possible? ...</div>
    </div>
</div>

<section class="gray container-fluid py-5" id="home-who-uses">
    <div class="container">
        <h2 class="mb-4">Who uses Tau Prolog?</h2>
        <div class="row">
    		<div class="col-lg">
                <a id="home-who-floper" href="http://dectau.uclm.es/floper/" target="_blank" title="FLOPER"></a>
                <p class="text-justify"><b>FLOPER</b> is a logic programming environment for research made up of a set of tools and applications for the FASILL language, a Prolog-like fuzzy logic programming language.</p>
            </div>
            <div class="col-lg">
                <a id="home-who-prologhub" href="https://prologhub.pl/" target="_blank" title="PrologHub"></a>
                <p class="text-justify"><b>PrologHub</b> is dedicated to bringing together the Prolog community to share ideas and knowledge, with the aim of encouraging the growth and development of the community.</p>
            </div>
            <div class="col-lg">
                <a id="home-who-klipse" href="http://blog.klipse.tech/" target="_blank" title="Klipse"></a>
                <p class="text-justify"><b>Klipse</b> is a JavaScript plugin for embedding interactive code snippets in tech blogs. A simple client-side code evaluator pluggable on any web page.</p>
            </div>
        </div>
	</div>
</section>