<div class="col-md-4">

               <br><br>
               <?php include "registration.php"; ?>

               <!-- Login -->
               <?php
    
                if(!isset($_SESSION['username'])){
                ?>
                    <?php include "login.php";  ?>
                        
                <?php }   ?>
               
               
                
                <!-- Blog Search Well -->
                <div class="well">
                    <h4> <?php echo _SEARCH; ?></h4>
                    
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
                
                    <h4> <?php echo _CATEGORIES; ?></h4>
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