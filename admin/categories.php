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
                                        find_all_categories();
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

   