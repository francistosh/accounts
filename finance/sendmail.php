
 <?php
require_once './Swift-5.1.0/lib/swift_required.php';

$transport = Swift_SmtpTransport::newInstance('mail.techsavanna.technology', 465,'ssl')
 ->setUsername('francis@techsavanna.technology')
 ->setPassword('Qwerty789#');

$mailer = Swift_Mailer::newInstance($transport);

//$data = '<html>'. 'this is a pdf file'. '</html>';
//$cid = $message->embed(Swift_Image::fromPath('./images/cross.png'));
//$attachment = Swift_Attachment::newInstance($data, 'my-file.pdf', 'application/pdf');
$message = Swift_Message::newInstance('PDDF FILE')
 ->setFrom(array('francis@techsavanna.technology' => 'ABB'))
 ->setTo(array('frankmutura@gmail.com'))     
 ->setBody(
' Here is an image '.
' Rest of message' 
);
//$message->attach($attachment);
$result = $mailer->send($message);
if ($result)
{
echo "Sent\n";
}
else
{
echo "Failed\n";
}
?>