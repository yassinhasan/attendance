<?php
use PHPMailer\PHPMailer\PHPMailer;

if(!function_exists("sendEmail"))
{
   // function sendEmail(array $to , array $attachement =[] , array $msg_details = [] )
    function sendEmail(array $details )
    {

        extract($details);
        $attachment = isset($attachment) ? $attachment : null;
        $attachmentname = isset($attachmentname) ? $attachmentname : null;
        $mail = new PHPMailer();
        try {
           //Server settings
           // $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'figo781@gmail.com';                     //SMTP username
            $mail->Password   = 'Hm054603591700';                               //SMTP password
            $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('figo781@gmail.com', 'Attendance website');
            $mail->addAddress($to, $toname);     //Add a recipient

        
            //Attachments
        //    $mail->addAttachment('/var/tmp/file.tar.gz');
        //    $attachment = toPublicDirectory("uploades/images/1.png");
           $mail->addAttachment($attachment, $attachmentname);    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}

//$imagesrc = toPublicDirectory("uploades/images/1.png");
// sendEMail([
//     "to"             => "marwamedhat87@gmail.com" , 
//     "toname"         => "marwa" , 
//     "attachment"     => $imagesrc,
//     "attachmentname" => "image",
//     "subject"        => "HELLO IAM TESTING THIS",
//     "body"           => " <h1> test msg </h1>",
//     "msg"            =>  " message sent" 
// ]);