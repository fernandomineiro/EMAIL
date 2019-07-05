<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include "../config.php";
session_start();


if(isset($_POST['send'])){

    $email = $_POST['email'];

    $subject = 'Senha recuperada';
    

    $sql = "SELECT senha FROM usuario WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $message = $row["senha"];

        require 'vendor/autoload.php';

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        
$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 0;        // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
$mail->SMTPAuth = true;        // Autenticação ativada
$mail->SMTPSecure = 'tls';    // TLS REQUERIDO pelo GMail
$mail->Host = 'smtp.gmail.com';    // SMTP utilizado
$mail->Port = 587;          // A porta 587 deverá estar aberta em seu servidor
$mail->Username = "teste2volner@gmail.com";
$mail->Password = "vaamerda";
        //Send Email
        $mail->setFrom($email);
        
        //Recipients
        $mail->addAddress($email);              
        $mail->addReplyTo($email);
        
        //Attachment
        if(!empty($filename)){
            $mail->addAttachment($location, $filename); 
        }
       
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->SMTPDebug = 3;
        $mail->send();
        $_SESSION['mensagem'] = 'Senha enviada para o seu email';
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro, consunte um adm: '.$mail->ErrorInfo;
    }
    echo "<script>window.location = '../recuperarsenha.php'</script>";
    }
} else {
    $_SESSION['mensagem'] = 'Não possui esse email cadastrado ';
    echo "<script>window.location = '../recuperarsenha.php'</script>";
}

    

    //Load composer's autoloader
    

   
}
else{
    $_SESSION['message'] = 'Please fill up the form first';
}   

?>

