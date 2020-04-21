<?php 
$alertDisplay = "none";
$alertContent = "Profile updated successfully!";
$error = "";

function get_user_data($username){
    global $connection, $user_id, $password, $userdb_firstname;
    global $userdb_lastname, $userdb_email, $userdb_role, $userdb_image;
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user_profile = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_array($select_user_profile)){
        $user_id = $row['user_id']; 
        $username = $row['username']; 
        $password = $row['password']; 
        $userdb_firstname = $row['user_firstname']; 
        $userdb_lastname = $row['user_lastname']; 
        $userdb_email = $row['user_email']; 
        $userdb_role = $row['user_role']; 
        $userdb_image = $row['user_image']; 
    }
}

function update_user($connection, $user_id, $username, $user_firstname,
                     $user_lastname, $user_email, $user_role, $password, $password_crypt, callable  $callback){
    $query = "UPDATE users SET ";
    $query .= "username = '{$username}', "; //username was took from global var.
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";

    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
        $query .= "user_role = '{$user_role}', ";
    }

    if(!empty($password))
        $query .= "password = '{$password_crypt}' ,";

    $query .= "user_email = '{$user_email}' ";
    $query .= " WHERE user_id = {$user_id}";

    $update_user_query = mysqli_query($connection, $query);
    confirm_query($update_user_query);

    //Calling callback
    $callback($username);
    //END callback

    return true;
}

if(isset($_SESSION['username'])){
    $username = escape($_SESSION['username']);
    get_user_data($username);
}


if(isset($_POST['edit_profile'])){
    if(isset($_POST['user_firstname']) && 
       isset($_POST['user_lastname']) && isset($_POST['user_email']) && isset($_POST['password'])){
        $user_firstname = escape($_POST['user_firstname']); 
        $user_lastname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);
        $password = escape($_POST['password']);
        $password_crypt = "";

        // encrypt password
        if(!empty($password))
            $password_crypt = password_hash($password, PASSWORD_BCRYPT, ['cost'=>10] );

        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
            $user_role = escape($_POST['user_role']);   
        }


        if($userdb_email !== $user_email){

            if(!mail_exists($user_email)){

                $result = update_user($connection, $user_id, $username, $user_firstname,
                    $user_lastname, $user_email, $user_role, $password,
                    $password_crypt, function($username){
                        get_user_data($username);
                    });

                if($result)
                    $alertDisplay = "block";

            }else{
                $error = "E-mail already exist.";
            }
        }else{

            $result = update_user($connection, $user_id, $username, $user_firstname,
                $user_lastname, $user_email, $user_role, $password,
                $password_crypt, function($username){
                    get_user_data($username);
                });

            if($result)
                $alertDisplay = "block";

        }
    }
    

}

?>

              <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <label for="user_firstname"> Firstname</label>
                    <input type="text" class="form-control" name="user_firstname" value="<?php echo $userdb_firstname ?>">    
                </div>

                <div class="form-group">
                <label for="user_lastname"> Lastname</label>
                    <input type="text" class="form-control" name="user_lastname" value="<?php echo $userdb_lastname ?>">    
                </div>

                
               
                <?php 
                if(isset($_SESSION['user_role'])){
                    $user_role = $_SESSION['user_role'];  
                    if($user_role == "admin"){
                        
                ?>    
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


                                        if($userdb_role == $role_name)
                                             echo "<option value='$role_name' selected> {$role_label} </option>";
                                         else
                                             echo "<option value='$role_name' > {$role_label} </option>"; 

                                     }
                                    ?>    

                                </select>
                            </div>
                <?php 
                        }
                    }
                        
                ?>
                

                <div class="form-group">
                <label for="username"> Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $username ?>" disabled>    
                </div>

                <div class="form-group">
                <label for="user_email"> E-mail</label>
                    <input type="email" class="form-control" name="user_email" value="<?php echo $userdb_email ?>">
                </div>

                <div class="form-group">
                <label for="password"> Password</label>
                    <input type="password" class="form-control" name="password" autocomplete="off">    
                </div>


                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="edit_profile" value="Update Profile">
                </div>

            </form>
            <br>

            <?php if($error !== ""){  ?>
                <div class="alert alert-dismissable alert-danger" >
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $error; ?>
                </div>

                <?php

            }
            ?>

            <div style="display: <?php echo $alertDisplay; ?>" class="alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong><?php echo $alertContent; ?></strong>
            </div>