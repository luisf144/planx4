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
    $time_out_in_seconds = 120;
    $time_out =  $time - $time_out_in_seconds;

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
    confirm_query($users_online_query);
    $users_online = [];

    while($row = mysqli_fetch_assoc($users_online_query)){
         array_push($users_online, $row['user_id']);
    }

    return $users_online;
}

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