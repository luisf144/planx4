<?php 

if(isset($_POST['checkBoxArray'])){
    $checkBoxArray = $_POST['checkBoxArray'];
    $bulk_options = escape($_POST['bulk_options']);

    foreach($checkBoxArray as $post_id){
        switch($bulk_options){
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$post_id}";
                break;
                
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
                $exec_query = mysqli_query($connection, $query);
                
                while($row = mysqli_fetch_assoc($exec_query)){
                    $post_author = $row['post_author']; 
                    $post_title = $row['post_title']; 
                    $post_category_id = $row['post_category_id']; 
                    $post_status = $row['post_status']; 
                    $post_image = $row['post_image']; 
                    $post_tags = $row['post_tags']; 
                    $post_content = $row['post_content']; 
                    $post_created_by = $_SESSION['username'];  
                    $post_date = date('Y-m-d H:i:s');
                }
                
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status, post_created_by ) ";
                $query .= "VALUES ('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}', '{$post_created_by}')";
                
                break;
                
            case 'reset_views':
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$post_id}";
                break;
                
            default:
                $query = "UPDATE posts SET post_status = '{$bulk_options}' ";
                $query .= "WHERE post_id = {$post_id}";   
                break;
        }

        $exec_query = mysqli_query($connection, $query);
        confirm_query($exec_query);
    }
}

?>
           

           <form action="" method="post">    

           <table class="table table-bordered hover">
            
               <div id="bulkOptionsContainer" class="col-xs-4">
                   <select class="form-control" name="bulk_options" id="">
                       <option value="">Select Option</option>
                       <option value="published">Published</option>
                       <option value="draft">Draft</option>
                       <option value="delete">Delete</option>
                       <option value="clone">Clone</option>
                       <option value="reset_views">Reset Views</option>
                   </select>
               </div>
               
               <div class="col-xs-8">
                   <input type="submit" name="submit" class="btn btn-success" value="Apply">
                   <a class="btn btn-primary" style="float:right;" href="posts.php?source=add_post">Add New</a> 
                   <a class="btn btn-info" href="posts.php?reload">
                   <i class="fa fa-refresh"></i> Reload
                   </a> 
               </div>
               
               <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $query = "SELECT posts.post_id, posts.post_author, posts.post_title, posts.post_category_id, posts.post_status, ";
            $query .= "posts.post_image, posts.post_tags, posts.post_views_count, posts.post_date, ";
            $query .= "categories.cat_id, categories.cat_title, COUNT(comments.comment_post_id) as count_comments ";
            $query .= "FROM posts ";
            $query .= "LEFT JOIN categories ";
            $query .= "ON posts.post_category_id = categories.cat_id ";
            $query .= "LEFT JOIN comments ";
            $query .= "ON posts.post_id = comments.comment_post_id ";
            $query .= "GROUP BY posts.post_id ";
            $query .= "ORDER BY posts.post_id DESC";

            $select_posts = mysqli_query($connection, $query);

             while($row = mysqli_fetch_assoc($select_posts)){
                $post_id = $row['post_id']; 
                $post_author = $row['post_author']; 
                $post_title = $row['post_title']; 
                $post_category_id = $row['post_category_id']; 
                $post_status = $row['post_status']; 
                $post_image = $row['post_image']; 
                $post_tags = $row['post_tags']; 
                $post_views_count = $row['post_views_count']; 
                $post_date = $row['post_date'];
                $cat_title = $row['cat_title'];
                $count_comments = $row['count_comments'];

                 echo "<tr>";
                 ?>
                 
                 <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
                 
                 <?php
                 echo "<td> $post_id </td>";
                 echo "<td> $post_author </td>";
                 echo "<td> <a href='../post.php?post_id=$post_id'>$post_title </a></td>";
                 echo "<td> $cat_title </td>";
                 echo "<td> $post_status </td>";
                 echo "<td> <img width=100 src='../images/$post_image' alt='image'>  </td>";
                 echo "<td> $post_tags </td>";
                 echo "<td> <a href='post_comments.php?post_id=$post_id'>$count_comments</a> </td>";
                 echo "<td> <p class='text-center'>$post_views_count</p> <a href='posts.php?reset={$post_id}'> Reset </a></td>";
                 echo "<td> $post_date </td>";
                 echo "<td> <a href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a> </td>";

                 ?>

                     <td>
                         <input type="button" class="btn btn-link btn-confirm"
                                data-value="<?php echo $post_id; ?>" name="delete" value="Delete">
                     </td>

                 <?php

                 echo "</tr>";
             }

            ?>              

            </tbody>
</table>

</form>

<?php include "../includes/modal_confirm.html"; ?>

<?php

if(isset($_POST['deletePostId'])){
    $post_id = $_POST['deletePostId'];
    $query = "DELETE FROM posts WHERE post_id = {$post_id}";
    $delete_query = mysqli_query($connection, $query);
      header("Location: posts.php");
}

if(isset($_GET['reset'])){
    $post_id = escape($_GET['reset']);
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$post_id}";
    $reset_query = mysqli_query($connection, $query);
      header("Location: posts.php");
}

if(isset($_GET['reload'])){
    header("Refresh:0; url=posts.php");
}

?>


