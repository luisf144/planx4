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
            
            include "../includes/db.php";
        }
        
        $user_id = 0;
        if(isset($_SESSION['user_id']))
            $user_id = escape($_SESSION['user_id']);
        
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

function insert_categories(){
    global $connection;
    
    if(isset($_POST['submit']))
    {
         $cat_title = escape($_POST['cat_title']);

          if($cat_title == "" || empty($cat_title)){
              echo "This field should not be empty";
          }else{
              $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
              $create_category_query = mysqli_query($connection, $query);

              confirm_query($create_category_query);
          }
    }
}

function find_all_categories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

     while($row = mysqli_fetch_assoc($select_categories)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td> <a href='categories.php?edit={$cat_id}'>Edit</a> </td>";
        echo "<td> <a href='categories.php?delete={$cat_id}'>Delete</a> </td>";
        echo "</tr>";
     }

}

function delete_categories(){
    global $connection;
    if(isset($_GET['delete'])){
        $cat_id = escape($_GET['delete']);
        $query = "DELETE FROM categories WHERE cat_id = {$cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }    
}

function update_categories(){
    global $connection, $cat_id; 
    if(isset($_POST['update_category'])){
        $cat_title = escape($_POST['cat_title']);
        $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";
        $update_query = mysqli_query($connection, $query);

        confirm_query($update_query);
    } 
}

?>