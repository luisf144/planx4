<?php  include "includes/header.php"; ?>

<?php

/* Require files needed */
require "./vendor/autoload.php";
/*  */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//use PHPMailer\PHPMailer\SMTP;

pdo_connect_mysql();
$pdo = pdo_connect_mysql();
$message = "";
$message_code = null;

if(!isset($_GET['forgot'])){
    redirect('index.php');
}

if(ifIsMethod("post") && isset($_POST['recover_submit'])){
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if(mail_exists($email)){
            $sql = "UPDATE users SET token = ? WHERE user_email = ?";
            $stmt = $pdo->prepare($sql);
            if($stmt->execute([$token, $email])){

                /*
                 * Configure PHPMailer
                 * */

                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {

                    $host  = $_SERVER['HTTP_HOST']; echo " ".$host. " ";
                    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); echo $uri." ";
                    $link = "https://$host$uri/reset.php?email=$email&token=$token";

                    //Server settings
//                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = Config::SMTP_HOST;                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = Config::SMTP_USERNAME;                     // SMTP username
                    $mail->Password   = Config::SMTP_PASSWORD;                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = Config::SMTP_PORT;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom('luisfcb14@gmail.com', 'Luis');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Recover Password - Planx4';
                    $mail->Body    = '<p> Please click to reset your password: 
                        <a href="'.$link.'"> '. $link .' </a>
 
                     </p>';

                    if($mail->send()){
                        $message = "We sent you and E-mail with the details for recovery.";
                        $message_code = 200;
                    }
                } catch (Exception $e) {
                    $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $message_code = 500;
                }


            }
        }else{
            $message = "The E-mail is not registered in the system.";
            $message_code = 500;
        }
    }
}

?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <br>
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body ">
                        <div class="text-center">



                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">




                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="E-mail address"
                                                   class="form-control" type="email" value="<?php echo isset($email) ? $email:'' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover_submit" class="btn btn-lg btn-info btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                                <?php if($message !== ""){  ?>
                                    <br>
                                    <div class="alert alert-dismissable <?php echo ($message_code === 200) ? "alert-success" : "alert-danger" ?>"  >
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <?php echo $message; ?>
                                    </div>

                                    <?php

                                }
                                ?>


                                <a href="index.php">
                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                   Come Back to Home Site!
                                </a>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

