<?php include "includes/header.php";  ?>
   
    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

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
                 $user_firstname = (isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] : "" );
                 $user_lastname = (isset($_SESSION['user_lastname']) ? $_SESSION['user_lastname'] : "" );
                
                ?>
                <h1 class="page-header">
                    
                     <?php echo get_greetings();?>
                    <small> <?php echo ($user_firstname ." ". $user_lastname);  ?> </small>
                </h1>

               
               <?php
                  
                  $all_posts_count = 0;
                  if(isset($_POST['submit']) || isset($_GET['search'])){
                   $search = isset($_POST['search']) ? escape($_POST['search']) : escape($_GET['search']);
                   $page = 0;
                    if(isset($_GET['page'])){
                        $page = escape($_GET['page']);
                    }

                    if($page == 0 || $page == 1)
                        $page_1 = 0;
                    else
                        $page_1 = ($page * 5) - 5;


                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'published' ";
                    $select_all_post_query = mysqli_query($connection, $query);
                    $all_posts_count = mysqli_num_rows($select_all_post_query);
                    $all_posts_count = ceil($all_posts_count / 5);

                    
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, 5";
                    $search_query = mysqli_query($connection, $query);
                    confirm_query($search_query);
                    
                    $count = mysqli_num_rows($search_query);
                    if($count == 0){
                       
                    ?>
                    
                    <br>
                    <br>
                    <br>
                    <br>
                    <img class="center-img" src="images/no_results.png" alt="noresults">
                    
                    <?php   
                        
                    }else{
                    
                    while($row = mysqli_fetch_assoc($search_query)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_category_id = $row['post_category_id'];
                        $post_tags = $row['post_tags'];
                        $post_created_by = $row['post_created_by'];
                        
                        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved'";
                        $exec_query = mysqli_query($connection, $query);
                        $count_comments = mysqli_num_rows($exec_query);    
                        
                        
                        //QUERY GET CATEGORY
                        $queryCategory = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                        $search_cat_query = mysqli_query($connection, $queryCategory);
                        
                        $cat_title = "";
                        while($row = mysqli_fetch_assoc($search_cat_query)){
                            $cat_title = $row['cat_title'];
                        }
                        //END


                ?>
               
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?post_id=<?php echo $post_id; ?> "> 
                    <?php echo $post_title  ?>
                    </a>
                </h2>
                
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_created_by; ?>">
                         <?php echo $post_author  ?> 
                       </a>
                </p>
                
                <p class="date-post">
                    <span class="glyphicon glyphicon-time"></span>  
                    <?php echo get_time_ago(strtotime($post_date));  ?>   
                </p>
                
                <br>
                <span style="font-size:100%" class="label label-primary"> 
                    <?php echo strtoupper($cat_title); ?>
                </span>
                
                <p class="comment-post"> 
                 <a href="post.php?post_id=<?php echo $post_id; ?>#comments-thread">
                    <i class="fa fa-comments" aria-hidden="true"></i> 
                    <?php echo $count_comments;  ?> Comments
                 </a>
                </p>
                <hr style="margin-top:12px">
                
                <img class="posts-img" src="images/<?php echo (($post_image != "") ? $post_image : 'default_post.jpg' ) ?>" alt="">
                
                <br><br>
                <p > 
                 <a href="post.php?post_id=<?php echo $post_id; ?>">
                    <i class="fa fa-tags" aria-hidden="true"></i> 
                    <?php echo $post_tags;  ?>
                 </a>
                </p>
                
                <hr>
                <blockquote>
                    <p class="descr-post">
                     <?php echo $post_content  ?>
                    </p>
                </blockquote>
                
                <a class="btn btn-info" href="post.php?post_id=<?php echo $post_id; ?> ">
                    Read more 
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

                <hr><br><br>     
                   
            <?php 
                } 
                        
            }
            }else{

            ?>          
            
                <div class="no-posts">
                    <img class="center-img" src="images/no_results.png" alt="no_results">
                </div>    

            <?php        
                }
            ?>
                
               
               
               
               

            

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
            

        </div>
        <!-- /.row -->


        <ul class="pager">
            <?php 
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            for($i = 1; $i <= $all_posts_count; $i++){
                if($current_page == $i)
                    echo "<li> <a href='search.php?search=$search&page={$i}' class='page-selected'> {$i} </a> </li>";
                else
                    echo "<li> <a href='search.php?search=$search&page={$i}'> {$i} </a> </li>";
            }
            
            ?>
        </ul>


<!-- Footer -->
<?php include "includes/footer.php"; ?>        
   
                
                