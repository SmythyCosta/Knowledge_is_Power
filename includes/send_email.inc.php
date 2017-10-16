<?php

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPOptions = array(
'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->Host = HOST_SMTP;
$mail->Port = PORT_SMTP;
$mail->SMTPAuth = PAUTH_SMTP;
$mail->Username = USERNAME_SMTP;
$mail->Password = PASSWORD_SMTP;
$mail->setFrom(USERNAME_SMTP);
$mail->addAddress($Address);  //verificar o email.
$mail->Subject = utf8_decode($Subject);
$mail->Charset = 'UTF-8';
$mail->msgHTML(utf8_decode("<html> {$body} </html>"));
$mail->AltBody = utf8_decode(" {$body} ");
if($mail->send()){
}
else {
    echo $mail->ErrorInfo;
}