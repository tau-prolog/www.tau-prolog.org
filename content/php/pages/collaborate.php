<div class="white container-fluid py-5">
    <div class="container">
        <h1>Collaborate</h1>
	</div>
</div>

<?php

$send = 2;

if( isset($_POST['submit']) ) {
	
	if( isset($_POST["g-recaptcha-response"]) ) {
		
		require("content/php/credentials.php");
		
		if( $captcha["success"] ) {
		
			if( isset($_POST['msg']) && $_POST['msg'] != '' && isset($_POST['mail']) && isset($_POST['name']) && $_POST['name'] != '' && $_POST['mail'] && isset($_POST['title']) && $_POST['title'] ) {

				require( "content/php/PHPMailer/Exception.php" );
				require( "content/php/PHPMailer/PHPMailer.php" );
				require( "content/php/PHPMailer/SMTP.php" );
				
				$name = htmlspecialchars($_POST['name']);
				$email = htmlspecialchars($_POST['mail']);
				$title = htmlspecialchars($_POST['title']);
				$msg = str_replace("\n", "<br />", htmlspecialchars($_POST['msg']));
				
				$mail = new PHPMailer\PHPMailer\PHPMailer(true);
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->CharSet = "UTF-8";
				$mail->Host = "smtp.gmail.com";
				$mail->Username = "tau.prolog@gmail.com"; 
				$mail->Password = $mail_password; 
				$mail->Port = 465;
				$mail->From = "tau.prolog@gmail.com";
				$mail->FromName = "Tau Prolog";
				$mail->AddAddress("tau.prolog@gmail.com");
				$mail->AddEmbeddedImage('http://tau-prolog.org/logo/tauprolog64.png', 'logo');
				if( isset($_POST["copy"]) ) 
					$mail->AddAddress($_POST["mail"]);
				$mail->IsHTML(true);
				$mail->Subject = "Tau Prolog: $_POST[title]";
				$mail->Body = "<div style=\"box-shadow: 0px 5px 0px #efefef; background-color:#ffffff; margin: 10px auto; width: 500px; border: 1px solid #bfbfbf; border-radius: 3px;\">";
				$mail->Body .= "<div style=\"border-bottom: 1px solid #bfbfbf; text-align: center; padding: 10px;\"><img src=\"http://tau-prolog.org/logo/tauprolog64.png\" /></div>";
				$mail->Body .= "<div style=\"font-family: arial; font-size: 15px; padding: 10px; \">";
				$mail->Body .= "<b>Name</b><br />$name<br /><br /><b>Email</b><br /><a href=\"mailto:$email\" style=\"color:#442178; text-decoration:none;\">$email</a><br /><br /><b>Title</b><br />$title<br /><br /><b>Message</b><br />$msg";
				$mail->Body .= "</div></div>";
				$mail->Body .= "<div style=\"color: #777777; font-size: 13px; text-align:center;\">Message sent from <a href=\"http://tau-prolog.org\" style=\"color:#442178; text-decoration:none;\">tau-prolog.org</a></div>";
				$mail->SMTPSecure = "ssl";
				$send = $mail->Send();
				
			} else {
				$send = 3;
			}
			
		} else {
			$send = 6;
		}
		
	} else {
		$send = 5;
	}

}

$action = false;

if( isset($_GET['action']) ) {
	$action = $_GET['action'];
}

?>



<?php if( $send === true ) { ?>
	<div class="yellow container-fluid py-3">
        <div class="container"><i class="fas fa-check"></i> Your message was sent correctly. Thank you for your collaboration.</div>
    </div>
<?php } elseif( $send === false ) { ?>
	<div class="yellow container-fluid py-3">
        <div class="container"><i class="fas fa-exclamation-triangle"></i> Sorry, there was an error. Try it again.</div>
    </div>
<?php } elseif( $send === 3 ) { ?>
	<div class="yellow container-fluid py-3">
        <div class="container"><i class="fas fa-exclamation-triangle"></i> All the fields are required.</div>
    </div>
<?php } elseif( $send === 5 ) { ?>
	<div class="yellow container-fluid py-3">
        <div class="container"><i class="fas fa-robot"></i> Sorry, you are not human.</div>
    </div>
<?php } elseif( $send === 6 ) { ?>
	<div class="yellow container-fluid py-3">
        <div class="container"><i class="fas fa-robot"></i> You must mark the captcha.</div>
    </div>
<?php } ?>

<div id="contact" class="purple container-fluid py-5">
    <div class="container">
        <h2 class="mb-4">Form contact</h2>
        <form action="/collaborate" method="post">
            <div class="form-group">
                <label for="mail">Email address</label>
                <input name="mail" value="<?php if($send != 2) { echo $_POST["mail"]; } ?>" type="email" class="form-control" aria-describedby="mailhelp" placeholder="Enter email" />
                <small id="mailhelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" value="<?php if($send != 2) { echo $_POST["name"]; } ?>" type="text" class="form-control" placeholder="Enter your name" />
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" value="<?php if($send != 2) { echo $_POST["title"]; } ?>" type="text" class="form-control" value="<?php if( $action == 'who' ) echo 'Who uses Tau Prolog?'; ?>" placeholder="Enter a title" />
            </div>
            <div class="form-group">
                <label for="msg">Message</label>
                <textarea name="msg" type="text" class="form-control" placeholder="Enter a message"><?php if($send != 2) { echo $_POST["msg"]; } ?></textarea>
            </div>
            <div class="g-recaptcha" data-sitekey="6LfwbXYUAAAAAM0PIG7bSXpJGUovCfDA8OGe2LO_"></div><br />
            <input id="submit_b" type="submit" name="submit" class="btn btn-lg mr-2" value="Submit email"/> <input type="checkbox" name="copy" id="copy" checked /> <label for="copy">Send me a copy</label>
        </form>
    </div>
</div>

<div class="yellow container-fluid py-5" id="contributors">
    <div class="container"> 
        <h2 class="mb-4">Collaborators</h2>
        <ul class="list-unstyled">
            <li class="mb-2 p-2 border"><i class="fas fa-star mr-2"></i> <span class="font-weight-bold">José A. Riaza</span> <span class="font-italic">(creator, lead developer)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-star mr-2"></i> <span class="font-weight-bold">Miguel Riaza</span> <span class="font-italic">(lead developer)</span></li>
        </ul>
        <h2 class="mb-4">Contributors</h2>
        <ul class="list-unstyled">
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Anne Ogborn</span> <span class="font-italic">(suggestions)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Jan Burse</span> <span class="font-italic">(bug reports, feedback)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Joe Torreggiani</span> <span class="font-italic">(support for npm, testing)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-star mr-2"></i> <span class="font-weight-bold">José M. García</span> <span class="font-italic">(ex-collaborator, documentation, support for npm, community manager)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Julian Dax</span> <span class="font-italic">(library enhancements)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Olof Rappestad</span> <span class="font-italic">(support for npm)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Paulo Moura</span> <span class="font-italic">(library enhancements, suggestions)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Rodrigo Lemos</span> <span class="font-italic">(bug reports)</span></li>
            <li class="mb-2 p-2 border"><i class="fas fa-smile mr-2"></i> <span class="font-weight-bold">Ulrich Neumerkel</span> <span class="font-italic">(bug reports, feedback on Prolog compliance testing)</span></li>
        </ul>
    </div>
</div>
