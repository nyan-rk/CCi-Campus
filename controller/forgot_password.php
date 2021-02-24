<?php

require '../model/connexion_bdd_ajax.php';


require_once('phpmailer/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$result = generatePassword(8);

//generate new password
function generatePassword($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}


//pass hashed
$hashedPassword = password_hash($result, PASSWORD_DEFAULT);

$sql = "UPDATE user SET pass_user = ? WHERE email = ?";
$db = $bdd->prepare($sql);
$db->execute([$result, htmlspecialchars($_POST['email'])]);


$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

echo "<pre>";

$headers = 'Voici votre nouveau Mot de passe' . '<br>'
    . $result
    . '<br>'
    . 'Veuillez vous rendre sur le lien suivant afin de vous connecter à Cardly.fr

Lien : http://cardly/login.php';

$subject = 'Voici mon test d\'envoi';


try {
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "teamcardly@gmail.com";  // GMAIL username
    $mail->Password   = "ET6Ee99XgjrDAFq$";            // GMAIL password
    $mail->AddReplyTo('teamcardly@gmail.com');
    $mail->AddAddress(htmlspecialchars($_POST['email']), 'Votre mail');
    $mail->SetFrom('teamcardly@gmail.com');
    // https://myaccount.google.com/lesssecureapps
    $mail->Subject = 'Cardly - ' . $subject;
    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
    $mail->MsgHTML($headers);
    $mail->AddAttachment('images/cardly.png');
    $mail->Send();

    echo "Mail sent";
} catch (phpmailerException $e) {
    echo "<br><br> PHPMailer Exception => " . $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo "<br><br> Generic Exception => " . $e->getMessage(); //Boring error messages from anything else!
}
echo "</pre>";
header('Location: ../login.php');
exit();
