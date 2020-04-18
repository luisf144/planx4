<?php 

if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
    $user_id = escape($_GET['user_id']);
    
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $select_user = mysqli_query($connection, $query);

     while($row = mysqli_fetch_assoc($select_user)){
        $user_id = $row['user_id']; 
        $username = $row['username']; 
        $password = $row['password']; 
        $user_firstname = $row['user_firstname']; 
        $user_lastname = $row['user_lastname']; 
        $user_email = $row['user_email']; 
        $user_role = $row['user_role']; 
        $user_image = $row['user_image']; 
     }
    
    
}

if(isset($_POST['edit_user'])){ 
    $username = escape($_POST['username']); 
    $user_firstname = escape($_POST['user_firstname']); 
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = escape($_POST['user_role']);
    $user_email = escape($_POST['user_email']);
    $password = escape($_POST['password']);
    
    if(!empty($password))
        $password_crypt = password_hash($password, PASSWORD_BCRYPT, ['cost'=>10] );
    
    $query = "UPDATE users SET ";
    $query .= "username = '{$username}', ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";

    if(!empty($password))
        $query .= "password = '{$password_crypt}', ";
    
    $query .= "user_email = '{$user_email}' ";    
    $query .= " WHERE user_id = {$user_id}";

    $update_user_query = mysqli_query($connection, $query);
    confirm_query($update_user_query);
}

?>
                               
                               
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label for="user_firstname"> Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname ?>">    
    </div>
    
    <div class="form-group">
    <label for="user_lastname"> Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname ?>">    
    </div>
    
    <div class="form-group">
    
       <label for="user_role"> Role </label>
       <br>
        <select name="user_role" id="">
            
        <?php 
        $query = "SELECT * FROM roles"; 
        $select_roles = mysqli_query($connection, $query);
        confirm_query($select_roles);       

         while($row = mysqli_fetch_assoc($select_roles)){
            $role_name = $row['role_name'];
            $role_label = $row['role_label'];
             
             
            if($user_role == $role_name)
                 echo "<option value='$role_name' selected> {$role_label} </option>";
             else
                 echo "<option value='$role_name' > {$role_label} </option>"; 

         }
        ?>    
                    
            
        </select>
    
    </div>
    
    <div class="form-group">
    <label for="username"> Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username ?>">    
    </div>
    
    <div class="form-group">
    <label for="user_email"> E-mail</label>
        <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>">    
    </div>
    
    <div class="form-group">
    <label for="password"> Password</label>
        <input type="password" class="form-control" name="password" autocomplete="off" >    
    </div>
    
   
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

</form>