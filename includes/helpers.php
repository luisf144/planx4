<?php
function checkUsernameExistDB($username){
    pdo_connect_mysql();
    $pdo = pdo_connect_mysql();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function mail_exists($email){
    pdo_connect_mysql();
    $pdo = pdo_connect_mysql();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user_email = :email");
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function redirect($location){
    header("Location: ". $location);
    exit;
}

function ifIsMethod($method = null){
    if($_SERVER['REQUEST_METHOD']  == strtoupper($method))
        return true;

    return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role']))
        return true;

    return false;
}