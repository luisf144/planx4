<?php include "includes/header.php";  ?>
   
    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
$user_firstname = (isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] : "" );
$user_lastname = (isset($_SESSION['user_lastname']) ? " ".$_SESSION['user_lastname'] : "" );       


//LOGIC DELETE COMMENT ->
if(isset($_POST['remove_comment'])){
    if(!empty($_POST['post_id']) && !empty($_POST['comment_id'])){
        $post_id = $_POST['post_id'];
        $comment_id = $_POST['comment_id'];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id}";
        $delete_query = mysqli_query($connection, $query);

        confirm_query($delete_query);
        header("Location: post.php?post_id=$post_id");
    }
}

?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               
               <?php
               
                $condition_id = "";
                if(isset($_GET['post_id'])){
                $post_id = escape($_GET['post_id']);

                $query_update_post = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                $exec_query = mysqli_query($connection, $query_update_post);
                confirm_query($exec_query);

                
                $query = "SELECT * FROM posts WHERE post_id = $post_id ";
                $select_all_post_query = mysqli_query($connection, $query);
                $posts_count_db = mysqli_num_rows($select_all_post_query);
                $posts_count = 0;
                    
                while($row = mysqli_fetch_assoc($select_all_post_query)){
                    $posts_count++;
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
                  
                <?php
                 if(isset($_SESSION['username'])){
                    $username = $_SESSION['username'];
                  if(($post_created_by == $username) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')){
                      
                ?>
                   
                <a class="btn btn-app" href="edit_post.php?post_id=<?php echo $post_id; ?>">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <b>Edit Post</b>
                </a>
                <br>   
                
                <?php 
                    }                  
                 }
    
                ?>
                   
                <!--  Blog Post -->  
                <h1 class="page-header">
                   <?php echo $post_title  ?>
                    
                </h1>
                
                <p class="lead">
                    by <a >
                         <?php echo $post_author  ?> 
                       </a>
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
    
                
                <img class="post-img" src="images/<?php echo (($post_image != "") ? $post_image : 'default_post.jpg' ) ?>" alt="post_img">
                <hr>
                <blockquote>
                    <p class="descr-post-u">
                     <?php echo $post_content  ?>
                    </p>
                </blockquote>

                    <?php include "includes/likes.php"; ?>
                <hr>
                    
            <?php
                
               }
               
                if($posts_count == 0){
                    header("Location: index.php");
                }
             
            }else{
                 header("Location: index.php");
                 }
            
            ?>
               
               
               
               
               <!--     Comment Section          -->
               <?php 
                
                if(isset($_POST['create_comment'])){
                    $post_id = escape($_GET['post_id']);
                    $comment_author = escape($_POST['comment_author']);
                    $comment_email = "";
                    $comment_content = escape($_POST['comment_content']);
                    $comment_status = "approved";
                    $comment_date = date('Y-m-d H:i:s');
                    $comment_created_by = $_SESSION['username']; 
                    
                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date, comment_created_by) ";
                    $query .= "VALUES ($post_id, '$comment_author', '$comment_email', '$comment_content', '$comment_status', '$comment_date', '$comment_created_by')";
                    
                    $create_comment_query = mysqli_query($connection, $query);
                    confirm_query($create_comment_query);
                    
                }
                
               ?>
               
               
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                       
                       <div class="form-group">
                           <label for="comment_author">Name</label>
                           <input type="text" class="form-control" name="comment_author" value="<?php echo $user_firstname.$user_lastname; ?>" readonly="readonly">
                       </div>
                       
                        <div class="form-group">
                            <textarea id="body" class="form-control" rows="5" name="comment_content" ></textarea>
                        </div>
                        
                        <?php
                         if(isset($_SESSION['username'])){

                        ?>
                            <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                        
                        <?php 
                         }else{
                        ?>
                            <a href="#login" name="create_comment" type="button" class="btn btn-info">Log In to comment</a>
                        
                        <?php } ?>    
                    </form>
                </div>


                <br>
                <br>
                <h4 class="comment-label" id="comments-thread">
                Comments
                (<?php
                    $post_id = escape($_GET['post_id']);
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC";
                    $select_comments = mysqli_query($connection, $query);    
                    $rowsTotal = mysqli_num_rows($select_comments);
                    
                    echo $rowsTotal; 
                ?>):</h4>
                
                <hr style="margin-top:10px">
                
               <?php
                if(!$rowsTotal){ 
               ?>    
               <div>
                    <p class="text-center" class="no-comment">No comments yet.</p>
                    <br>
                    <br>
                </div>
                <?php } ?>
                
                
                <!-- Posted Comments -->
                  <?php 
                    
                    $count = 0;
                     while($row = mysqli_fetch_array($select_comments)){
                        $count++;
                        $comment_id = $row['comment_id']; 
                        $comment_author = $row['comment_author']; 
                        $comment_content = $row['comment_content']; 
                        $comment_date = $row['comment_date']; 
                        $comment_created_by = $row['comment_created_by']; 

                     
                ?>

                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" >
                                <img width="45" class="media-object" src="images/user_default.png" alt="user_img">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
                                   <?php echo $comment_author ?>
                                </h4>
                                
                                <div>
                                    <?php
                                     if(isset($_SESSION['username'])){
                                        $username = $_SESSION['username'];
                                      if(($comment_created_by == $username) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')){

                                    ?>

                                          <form action="" method="post">
                                              <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                              <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                                              <button type="submit" class="i-delete" name="remove_comment" >
                                                  <i class="fa fa-trash" aria-hidden="true"></i>
                                              </button>
                                          </form>
                                    
                                    <?php
                                      }
                                     }
                                    ?>
                                </div>
                                
                               
                               <div class="comment-content">
                                   <?php echo $comment_content ?>
                               </div>
                               
                               
                               <small class="post-time">
                                         <span class="glyphicon glyphicon-time"></span>  
                                         <?php echo get_time_ago(strtotime($comment_date));  ?>  
                               </small>

                            </div>
                        </div>
                        
                        
                        <?php if($count < $rowsTotal){
                        ?>
                        <hr>   
                        <?php } ?>
                        
                        <!--         END      -->
               
                  <?php  }  ?>

            

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
            

        </div>
        <!-- /.row -->

<script>
ClassicEditor
        .create( document.querySelector( '#body' ),{    
        toolbar: [ 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
        } )
        .catch( error => {
            console.error( error );
        } );
    
</script>

<!-- Footer -->
<?php include "includes/footer.php"; ?>        
