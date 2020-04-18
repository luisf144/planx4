<?php include "includes/header.php";  ?>
   
    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php
$user_firstname = (isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] : "" );
$user_lastname = (isset($_SESSION['user_lastname']) ? " ".$_SESSION['user_lastname'] : "" );       

?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php
                 if(isset($_SESSION['username'])){
                      
                ?>
                   
                    <a class="btn btn-app" href="add_post.php">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <b>New Post</b>
                    </a>

                    <br>
                
                <?php 
                  
                 }
                
                ?>
              
              
               <?php
                if(isset($_GET['author']) && !empty($_GET['author'])){
                    $author_username = escape($_GET['author']);
                }else{
                    header("Location: index.php");
                }
                
                $query = "SELECT * FROM posts WHERE post_created_by = '$author_username'";
                $select_all_post_query = mysqli_query($connection, $query);
                $select_first_post_query = mysqli_query($connection, $query);
                $first_post = mysqli_fetch_assoc($select_first_post_query);
                
                if(!$first_post)
                    header("Location: index.php");
                
                ?>
                     
                <h1 class="page-header">
                   Posted by <?php echo $first_post['post_author'];  ?>
                    
                </h1>
                                                                                                                              
                <?php                                        
                while($row = mysqli_fetch_assoc($select_all_post_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    $post_created_by = $row['post_created_by'];
                    
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved'";
                    $exec_query = mysqli_query($connection, $query);
                    $count_comments = mysqli_num_rows($exec_query);   
                ?>
                  
                
                <!--  Blog Post -->
                <h2>
                    <a href="post.php?post_id=<?php echo $post_id; ?> "> 
                        <?php echo $post_title;  ?>
                    </a>
                </h2>
                <p class="lead">
                    by  <?php echo $post_author;  ?> 
                </p>
                
                <p class="date-post">
                    <span class="glyphicon glyphicon-time"></span>
                    <?php echo get_time_ago(strtotime($post_date));  ?>   
                </p>
                <br>
                
                <span class="label label-primary post-label"> 
                    <?php echo strtoupper($cat_title); ?>
                </span>
                
                <p class="comment-post">
                    <a href="#comments-thread">
                     <i class="fa fa-comments" aria-hidden="true"></i> 
                     <?php echo $count_comments;  ?> Comments   
                    </a>
                </p>
                <hr style="margin-top:12px">
    
                <img class="posts-img" src="images/<?php echo (($post_image != "") ? $post_image : 'default_post.jpg' ) ?>" alt="post_img">
                <hr>
                <blockquote>
                    <p class="descr-post">
                         <?php echo $post_content  ?>
                    </p>
                </blockquote>
                <hr>    
                   
                   
            <?php  }  ?>

            
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
            

        </div>
        <!-- /.row -->


<!-- Footer -->
<?php include "includes/footer.php"; ?>        
