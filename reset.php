<?php  include "includes/header.php"; ?>

<?php

    pdo_connect_mysql();
    $pdo = pdo_connect_mysql();
    $message = "";
    $message_code = null;

    if( (!isset($_GET['email'])
        && !isset($_GET['token'])) || !isset($_GET['email']) || !isset($_GET['token']) ){
        redirect("index.php");
    }

    $token = $_GET['token'];
    $sql = "SELECT username, user_email, token FROM users WHERE token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':token', $token, PDO::PARAM_STR);

    if($stmt->execute()){
        $user = $stmt->fetch();
        if(($user['user_email'] != $_GET['email'])
            && ($user['token'] != $_GET['token'])
            || ($user['token'] != $_GET['token']) || $user['user_email'] != $_GET['email']){
                redirect("index.php");
        }
    }


    if(isset($_POST['reset_password'])){

        if(isset($_POST['password']) && isset($_POST['confirm_password'])
            && !empty($_POST['password']) && !empty($_POST['confirm_password'])){

            if($_POST['password'] === $_POST['confirm_password']){
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                $sql = "UPDATE users SET token = ?, password = ? WHERE user_email = ?";
                $stmt = $pdo->prepare($sql);
                if($stmt->execute(['', $hashed_password, $_GET['email']])){
                    $message = "The password was changed. Go to Login!";
                    $message_code = 200;

                    redirect("index.php");
                }else{
                    $message = "The password cannot be changed.";
                    $message_code = 500;
                }
            }else{
                $message = "Both passwords need to be equal.";
                $message_code = 500;
            }
        }else{
            $message = "Enter a password.";
            $message_code = 500;
        }

    }

?>


<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<div class="container">

    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirm_password" name="confirm_password" placeholder="Confirm password" class="form-control"  type="password" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="reset_password" class="btn btn-lg btn-info btn-block" value="Reset Password" type="submit">
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

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->
