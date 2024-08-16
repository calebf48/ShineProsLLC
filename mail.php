<?php 

require __DIR__ . '/vendor/autoload.php';

//Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST["button-submit"])) {

    //Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["cust_number"];
    $street_address = $_POST["street-address"];
    $postal_code = $_POST["postal-code"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $res_com = $_POST["res-com"];

    try {
    //server settings

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;             //Enable for verbose debugging output

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = $_SERVER['mail_host'];
    $mail->SMTPSecure = $_SERVER['encryption'];
    $mail->Port = $_SERVER['port'];

    $mail->Username = $_SERVER['username'];
    $mail->Password = $_SERVER['password'];

    $mail->setFrom($_SERVER['username'], $_SERVER['company_name']);
    $mail->addAddress($_SERVER['to_address'], $_SERVER['to_name']);

    //Content
    $mail->isHTML(true);
    $mail->Subject = "ShineProsLLC New Inquiry";
    $mail->Body = "<h3>A customer has requested a quote!</h3>
        <h4>Name: $name</h4>
        <h4>Email: $email</h4>
        <h4>Phone Number: $number</h4>
        <h4>Address: $street_address, $city, $state, $postal_code</h4>
        <h4>Property Type: $res_com</h4>
    ";

    $mail->send();

    echo "email sent";
    }
    catch(Exception $e){
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else {
    header("Location: index.html");
    exit(0);
}

?>


