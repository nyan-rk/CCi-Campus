<html>
  <head>
    <title>PHPMailer - SMTP (Gmail) advanced test</title>
  </head>
  <body>

    <?php
      require_once('class.phpmailer.php');
      //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

      $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

      $mail->IsSMTP(); // telling the class to use SMTP

      try 
      {
        $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 587;                   // set the SMTP port for the GMAIL server
        $mail->Username   = "moussasenetelemaque@gmail.com";  // GMAIL username
        $mail->Password   = "GERMANY66";            // GMAIL password
        $mail->AddReplyTo('moussasenetelemaque@gmail.com', 'Virux');
        $mail->AddAddress('mouhamed.diop89@gmail.com', 'El Presidente');
        $mail->SetFrom('moussasenetelemaque@gmail.com', 'Virusman Corporation');
        $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
        $mail->MsgHTML(file_get_contents('contents.html'));
        $mail->AddAttachment('images/phpmailer.gif');      // attachment
        $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
        $mail->Send();
        echo "<p>Congratulation, the message has been sent !!!</p>";
      }
      catch (phpmailerException $e) 
      {
        echo "<br><br> PHPMailer Exception => ".$e->errorMessage(); //Pretty error messages from PHPMailer
      }
      catch (Exception $e) 
      {
        echo "<br><br> Generic Exception => ".$e->getMessage(); //Boring error messages from anything else!
      }
    ?>

  </body>
</html>