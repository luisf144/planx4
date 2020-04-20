<?php include "includes/header.php"; ?>
   
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        
                        <?php include "includes/breadcrumb.php"; ?>
                        
                        <div class="col-xs-6">    
                        
                            <?php insert_categories(); ?>   
                        
                              
                            <form action="" method="post">
                                
                                <div class="form-group">
                                <label for="cat-title"> Add Category</label>
                                    <input type="text" class="form-control" name="cat_title">    
                                </div>
                                
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                                </div>
                                
                            </form>
                            
                            
                            
                            <?php 
                            
                            if(isset($_GET['edit'])){
                                include "includes/update_categories.php";
                                
                            }
                            
                            ?>
            
                            
                        </div>
                        
                        <div class="col-sm-6 col-xs-12">
                            <div class="table-responsive">
                                   <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category Title</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                     <?php
                                     $result_query = find_all_categories();
                                     while($row = mysqli_fetch_assoc($result_query)){
                                         $cat_title = $row['cat_title'];
                                         $cat_id = $row['cat_id'];

                                         echo "<tr>";
                                         echo "<td>{$cat_id}</td>";
                                         echo "<td>{$cat_title}</td>";
                                         echo "<td> <a href='categories.php?edit={$cat_id}'>Edit</a> </td>";

                                         ?>

                                         <form action="" method="post">
                                             <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                                             <td>
                                                 <button type="submit" name="delete_category" class="btn btn-link">
                                                     Delete
                                                 </button>
                                             </td>
                                         </form>

                                         <?php

                                         echo "</tr>";
                                     }


                                    delete_categories();
                                    ?>


                                    </tbody>
                                </table> 
                            </div>
                               
                        </div>
                        

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    
    <?php include "includes/footer.php"; ?>

   