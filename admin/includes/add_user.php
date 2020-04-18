<?php 
$alertDisplay = "none";
$alertContent = "User created successfully!";

if(isset($_POST['create_user'])){ 
    if(isset($_POST['username']) && 
       isset($_POST['password']) && 
       isset($_POST['user_role']) && !empty($_POST['username']) 
       && !empty($_POST['password']) && !empty($_POST['user_role'])){
        
            $username = escape($_POST['username']); 
            $user_firstname = escape($_POST['user_firstname']); 
            $user_lastname = escape($_POST['user_lastname']);
            $user_role = escape($_POST['user_role']);
            $user_email = escape($_POST['user_email']);
            $password = escape($_POST['password']);
            $password_crypt = password_hash($password, PASSWORD_BCRYPT, ['cost'=>10] );

            $query = "INSERT INTO users(username, user_firstname, user_lastname, user_role, user_email, password) ";

            $query .= " VALUES( '{$username}', '{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$user_email}', '{$password_crypt}' )";

            $create_user_query = mysqli_query($connection, $query);
            confirm_query($create_user_query);
            $alertDisplay = "block";   
    }
}

?>
                              

<div style="display: <?php echo $alertDisplay; ?>" class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong><?php echo $alertContent; ?></strong>
</div>
                               
                               
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label for="user_firstname"> Firstname</label>
        <input type="text" class="form-control" name="user_firstname">    
    </div>
    
    <div class="form-group">
    <label for="user_lastname"> Lastname</label>
        <input type="text" class="form-control" name="user_lastname">    
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
             
            echo "<option value='$role_name' > {$role_label} </option>";

         }
        ?>    
                    
            
        </select>
    
    </div>
    
    <div class="form-group">
    <label for="username"> Username</label>
        <input type="text" class="form-control" name="username">    
    </div>
    
    <div class="form-group">
    <label for="user_email"> E-mail</label>
        <input type="text" class="form-control" name="user_email">    
    </div>
    
    <div class="form-group">
    <label for="password"> Password</label>
        <input type="password" class="form-control" name="password" autocomplete="off">    
    </div>
    
   
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>

</form>