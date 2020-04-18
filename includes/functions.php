<?php

function confirm_query($result){
    global $connection;
     if(!$result){
        die('Query failed, message: ' . mysqli_error($connection));
    }
}

function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function get_users_online(){
    global $connection;
    $time = time();
    $time_out_in_seconds = 05;
    $time_out =  $time - $time_out_in_seconds;

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");

    $users_online = [];
    while($row = mysqli_fetch_assoc($users_online_query)){
        $users_online[] = $row['user_id'];
    }
   
    return $users_online;
}

function users_online(){
    global $connection;

    if(isset($_GET['onlineusers'])){
        if(!$connection){
            session_start();
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out =  $time - $time_out_in_seconds;
            
            include "db.php";
        }
        
        $user_id = 0;
        if(isset($_SESSION['user_id']))
            $user_id = $_SESSION['user_id'];
        
        $query = "SELECT * FROM users_online WHERE session = '$session' AND user_id = $user_id";
        $exec_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($exec_query);

        if(!$count){
            $result = mysqli_query($connection, "INSERT INTO users_online(user_id, session, time) VALUES($user_id, '$session', '$time')");
            confirm_query($result);
        }else{
            $result = mysqli_query($connection, "UPDATE users_online SET time='$time' WHERE session='$session' AND user_id = $user_id");
            confirm_query($result);
        }

        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");

        echo mysqli_num_rows($users_online_query);
        
    }
    
    
    
}

/** CALLING FUNCTION **/
users_online();
/** END **/

function checkUsernameExistDB($username){
    global $connection;
    pdo_connect_mysql();
    $pdo = pdo_connect_mysql();
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function get_time_ago($time){ 
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function get_greetings(){
    $now = date('H');
    
    if($now < 12){
        return "Good Morning";
    }elseif($now > 11 && $now < 17){
        return "Good Afternoon";
    }elseif($now >= 17){
        return "Good Evening";
    }else{
        return "Welcome";
    }
    

}