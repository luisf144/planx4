  <?php
   require './vendor/autoload.php';
  ?>

   <?php
    pdo_connect_mysql();
    $pdo = pdo_connect_mysql();
    $error = "";
   $dotenv = Dotenv\Dotenv::createImmutable("./");
   $dotenv->load();

   $options = array(
       'cluster' => 'eu',
       'useTLS' => true
   );
   $pusher = new Pusher\Pusher(
       getenv('PUSHER_APP_KEY'),
       getenv('PUSHER_APP_SECRET'),
       getenv('PUSHER_APP_ID'),
       $options
   );


    if(isset($_POST['sign_up'])){
        if(isset($_POST['username']) && isset($_POST['password']) 
           && isset($_POST['user_firstname'])){
            $username = $_POST['username'];
            $user_firstname =$_POST['user_firstname']; 
            $user_lastname = $_POST['user_lastname'];
            $password = $_POST['password'];
            $user_role = "subscriber";

            if(!empty($username) && !empty($user_firstname) && !empty($password)){
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost'=>12] );

                if(checkUsernameExistDB($username)){
                $error = 'The Username already exists.';

                }else{
                    $sql = "INSERT INTO users(username, user_firstname, user_lastname, user_role, password) ";
                    $sql .= " VALUES( :username, :user_firstname, :user_lastname, :user_role, :password )";
                    $query = $pdo->prepare($sql);
                    
                    $query->bindParam(':username',$username,PDO::PARAM_STR);
                    $query->bindParam(':user_firstname',$user_firstname,PDO::PARAM_STR);
                    $query->bindParam(':user_lastname',$user_lastname,PDO::PARAM_STR);
                    $query->bindParam(':user_role',$user_role,PDO::PARAM_STR);
                    $query->bindParam(':password',$password,PDO::PARAM_STR);
                    $query->execute();
                    
                    // Check that the insertion really worked. If the last inserted id is greater than zero, the insertion worked.
                    $lastInsertId = $pdo->lastInsertId();
                    unset($pdo);
                    if($lastInsertId){
                        $_SESSION['user_id'] = $lastInsertId;
                        $_SESSION['username'] = $username;
                        $_SESSION['user_firstname'] = $user_firstname;
                        $_SESSION['user_lastname'] = $user_lastname;
                        $_SESSION['user_role'] = $user_role;

                        //PUSHER
                        $pusher->trigger('notifications', 'new_user', $username);

                        header("Location: index.php");
                    }else{
                        die('QUERY FAILED ' . mysqli_error($connection));
                    }

                }
            }else{
                $error = 'The fields cannot be empty.';
            }   
        }
    }


    if(!isset($_SESSION['username'])){
    ?>
                
                    <div class="well" id="registration">
                        <h4><?php echo _CREATE_ACCOUNT; ?></h4>
                        <!-- search form                     -->                
                       <form action="" method="post"> 
                       
                       <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="user_firstname" placeholder="<?php echo _FIRST_NAME; ?>"
                                           required="required" autocomplete="on" value="<?php echo isset($user_firstname) ? $user_firstname :'' ?>">
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="user_lastname" placeholder="<?php echo _LAST_NAME; ?>"
                                           required="required" autocomplete="on" value="<?php echo isset($user_lastname) ? $user_lastname :'' ?>">
                                </div>
                            </div>        	
                        </div>
                
                       <div class="form-group">
                            <input name="username" placeholder="<?php echo _USERNAME; ?>" type="text" class="form-control"
                                   required="required" autocomplete="on" value="<?php echo isset($username) ? $username :'' ?>">
                        </div>

                        <div class="input-group">
                            <input name="password" placeholder="<?php echo _PASSWORD; ?>" type="password" class="form-control" required="required">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" name="sign_up" type="submit">
                                     <?php echo _SIGN_UP; ?>
                                </button>
                            </span>
                        </div>


                        </form>

                        <!-- /.input-group -->
                        
                        
                        
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
                        
    <?php }   ?>