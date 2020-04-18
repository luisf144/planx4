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
                 
                       
                       <?php 
                        
                       $source = "";
                       if(isset($_GET['source'])){
                           $source = escape($_GET['source']);
                       }
                        
                        switch($source){
                            case 'add_post':
                                include "includes/add_post.php";
                            break;
                        
                            case 'edit_post':
                                include "includes/edit_post.php";
                            break;
                            
                            default:    
                                include "includes/view_all_comments.php";    
                            break;
                        }
                        
                       ?>
                       
                       

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

   