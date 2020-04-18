<div class="col-md-4">

               <br><br>
               <?php include "registration.php"; ?>

               <!-- Login -->
               <?php
    
                if(!isset($_SESSION['username'])){
                ?>

                    <br>                
                    <div class="well" id="login">
                        <h4>Log In</h4>
             
                       <form action="includes/login.php" method="post"> 
                       <div class="form-group">
                            <input name="username" placeholder="Enter Username" type="text" class="form-control">  
                        </div>

                        <div class="input-group">
                            <input name="password" placeholder="Enter Password" type="password" class="form-control" >  
                            <span class="input-group-btn">
                                <button class="btn btn-primary" name="login" type="submit">
                                    Log In
                                </button>
                            </span>
                        </div>


                        </form>

            
                          <?php if(isset($_SESSION['errorLogin'])){  ?>
                            <br>
                            <div class="alert alert-dismissable alert-danger" >
                              <button type="button" class="close" data-dismiss="alert">×</button>
                                <?php echo $_SESSION['errorLogin']; ?>
                            </div>
                               
                          <?php
                                   unset($_SESSION['errorLogin']);
                                } 
                          ?>
                        
                        
                    </div>
                        
                <?php }   ?>
               
               
                
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Search</h4>
                    
                    <!-- search form                     -->                
                   <form action="search.php" method="post"> 
                   <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    
                    
                    </form>
                </div>

                
                <!-- Blog Categories Well -->
                <div class="well">
                   
                   <?php 
                    
                    $query = "SELECT * FROM categories";
                    $select_categories_sidebar = mysqli_query($connection, $query);
                
                    ?>   
                
                    <h4>Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                
                                <?php 
                                
                                 while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];

                                    echo "<li> <a href='category.php?category_id=$cat_id'> {$cat_title} </a> </li>";
                                 }
                    
                                ?>
                                                
                            </ul>
                        </div>
                       
                    </div>
                    <!-- /.row -->
                </div>
                
                
                <!-- Side Widget Well -->
                <?php include "widget.php"  ?>

</div>