<?php
require_once('phpmailer/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

echo "<pre>";

$htmlMessage = '<body style="margin: 10px;">' . nl2br(htmlspecialchars($_POST['message'])) . '</body>';
$subject = htmlspecialchars($_POST['subject']);
$senderName = htmlspecialchars($_POST['name']) . " " . htmlspecialchars($_POST['firstname']);
try {
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "teamcardly@gmail.com";  // GMAIL username
    $mail->Password   = "ET6Ee99XgjrDAFq$";            // GMAIL password
    $mail->AddReplyTo(htmlspecialchars($_POST['email']), $senderName);
    $mail->AddAddress('teamcardly@gmail.com', 'Cardly Team');
    $mail->SetFrom(htmlspecialchars($_POST['email']), $senderName);
    // https://myaccount.google.com/lesssecureapps
    $mail->Subject = 'Cardly - ' . $subject;
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
    $mail->MsgHTML($htmlMessage);
    $mail->AddAttachment('images/cardly.png');
    $mail->Send();
    echo "Mail sent";
} catch (phpmailerException $e) {
    echo "<br><br> PHPMailer Exception => " . $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo "<br><br> Generic Exception => " . $e->getMessage(); //Boring error messages from anything else!
}
echo "</pre>";
