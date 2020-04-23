<?php

function confirm_query($result){
    global $connection;
     if(!$result){
        die('Query failed, message: ' . mysqli_error($connection));
    }
}

function query($query){
    global $connection;
    $exec_query = mysqli_query($connection, $query);
    confirm_query($exec_query);

    return $exec_query;
}

function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}


function loggedInUserId(){

    if(isLoggedIn()){
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM users WHERE username = '$username' ";
        $result = query($sql);
        confirm_query($result);
        $user = mysqli_fetch_array($result);

        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }

    return false;
}

function userLikedThePost($post_id = '', $user_id = ''){
    $result = query("SELECT * FROM likes WHERE user_id = ". (empty($user_id) ? loggedInUserId() : $user_id)." AND post_id = $post_id");
    confirm_query($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostLikes($post_id = ''){
    $result = query("SELECT * FROM likes WHERE post_id = $post_id");
    confirm_query($result);
    return mysqli_num_rows($result);
}

function users_online(){
    global $connection;

    if(isset($_GET['onlineusers'])) {
        if (!$connection) {
            include "../includes/db.php";
        }

        $time = time();
        $time_out_in_seconds = 120;
        $time_out = $time - $time_out_in_seconds;
        session_start();
        $session = session_id();

        $user_id = 0;
        if (isset($_SESSION['user_id']))
            $user_id = escape($_SESSION['user_id']);

        $query = "SELECT * FROM users_online WHERE session = '$session' ";
        $exec_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($exec_query);

        if (!$count) {
            $result = mysqli_query($connection, "INSERT INTO users_online(user_id, session, time) VALUES($user_id, '$session', '$time')");
            confirm_query($result);
        } else {
            $result = mysqli_query($connection, "UPDATE users_online SET time='$time', user_id=$user_id WHERE session='$session'");
            confirm_query($result);
        }

        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");

        echo mysqli_num_rows($users_online_query);

    }

}

/** CALLING FUNCTION **/
users_online();
/** END **/

function get_time_ago($time){
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return   _LESS_TIME; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  _YEAR,
                30 * 24 * 60 * 60       =>  _MONTH,
                24 * 60 * 60            =>  _DAY,
                60 * 60                 =>  _HOUR,
                60                      =>  _MINUTE,
                1                       =>  _SECOND
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' '._AGO;
        }
    }
}

function get_greetings(){
    $now = date('H');

    if($now < 12){
        return _MORNING;
    }elseif($now > 11 && $now < 17){
        return _AFTERNOON;
    }elseif($now >= 17){
        return _NIGHT;
    }else{
        return "Welcome";
    }

}