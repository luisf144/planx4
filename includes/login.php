<?php 
pdo_connect_mysql();
$pdo = pdo_connect_mysql();
$error = "";

if(isset($_POST['login'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];


        // Prepare the SQL statement and get records from our user table
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        // Fetch the records 

        $user_id = $db_username = $db_password = $user_firstname = $user_lastname = $user_role = "";
        while($user = $stmt->fetch()){
            $user_id = $user['user_id'];
            $db_username = $user['username'];
            $db_password = $user['password'];
            $user_firstname = $user['user_firstname'];
            $user_lastname = $user['user_lastname'];
            $user_role = $user['user_role'];

        }

        unset($stmt);
        unset($pdo);

        if(password_verify($password, $db_password)){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['user_firstname'] = $user_firstname;
            $_SESSION['user_lastname'] = $user_lastname;
            $_SESSION['user_role'] = $user_role;

            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


            if($user_role == "admin")
                header("Location: http://$host$uri/admin/index.php");
            else
                header("Location: http://$host$uri/index.php");
        }else{
            $error = 'Username or Password invalid.';
        }   
    }
    
}

?>

<br>
<div class="well" id="login">
    <h4>Log In</h4>

    <form action="" method="post">
        <div class="form-group">
            <input name="username" placeholder="Enter Username" type="text"
                   class="form-control" autocomplete="on" value="<?php echo isset($username) ? $username:"" ?>">
        </div>

        <div class="input-group">
            <input name="password" placeholder="Enter Password" type="password" class="form-control" >
            <span class="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">
                    Log In
                </button>
            </span>
        </div>

        <div class="form-group forgot-link">
            <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">
                Forgot Password?
            </a>
        </div>


    </form>


    <?php if($error !== ""){  ?>
        <br>
        <div class="alert alert-dismissable alert-danger" >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo $error; ?>
        </div>

    <?php

    }
    ?>


</div>
