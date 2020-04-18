<?php 
include "db.php";
session_start();
pdo_connect_mysql();
$pdo = pdo_connect_mysql();


if(isset($_POST['login'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];


        // Prepare the SQL statement and get records from our user table
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        // Fetch the records 

        $user_role = "";
        while($user = $stmt->fetch()){
            $user_id = $user['user_id'];
            $db_username = $user['username'];
            $db_password = $user['password'];
            $user_firstname = $user['user_firstname'];
            $user_lastname = $user['user_lastname'];
            $user_role = $user['user_role'];

        }

        if(password_verify($password, $db_password)){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['user_firstname'] = $user_firstname;
            $_SESSION['user_lastname'] = $user_lastname;
            $_SESSION['user_role'] = $user_role;

            if($user_role == "admin")
                header("Location: ../admin");
            else
                header("Location: ../index.php");
        }else{
            $_SESSION['errorLogin'] = 'Username or Password invalid.';
            header("Location: ../index.php");
        }   
    }
    
}