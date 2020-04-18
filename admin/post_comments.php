<?php 

if(!isset($_GET['post_id']) || empty($_GET['post_id'])){
    header("Location: posts.php");
}

?>


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

           <form action="" method="comment">    

           <table class="table table-bordered hover">
               
               <thead>
                <tr>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>In Response to</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Approve</th>
                    <th>Unapprove</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>

            <?php 

            $query = "SELECT * FROM comments WHERE comment_post_id = ". escape($_GET['post_id'])." ORDER BY comment_id DESC";
            $select_comments = mysqli_query($connection, $query);
            confirm_query($select_comments);

             $count_rows = 0;    
             while($row = mysqli_fetch_assoc($select_comments)){
                $count_rows++;
                $comment_id = $row['comment_id']; 
                $comment_author = $row['comment_author']; 
                $comment_content = $row['comment_content']; 
                $comment_email = $row['comment_email']; 
                $comment_status = $row['comment_status']; 
                $comment_post_id = $row['comment_post_id']; 
                $comment_date = $row['comment_date']; 

                 echo "<tr>";
                 
                 echo "<td> $comment_id </td>";
                 echo "<td> $comment_author </td>";
                 echo "<td> $comment_content </td>";
                 
                 
                $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
                $select_post_id = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_post_id)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];

                    echo "<td> <a href='../post.php?post_id=$post_id'>$post_title</a> </td>";
                 }
                 
                 echo "<td> $comment_email </td>";
                 echo "<td> $comment_status </td>";
                 echo "<td> $comment_date </td>";

                 echo "<td> <a href='post_comments.php?approve={$comment_id}&post_id={$post_id}'>Approve</a> </td>";
                 echo "<td> <a href='post_comments.php?unapprove={$comment_id}&post_id={$post_id}'>Unapprove</a> </td>";
                 echo "<td> <a href='post_comments.php?delete={$comment_id}&post_id={$post_id}'>Delete</a> </td>";
                 echo "</tr>";
             }
                
                if(!$count_rows){
                    echo "<tr> <td colspan='12' class='text-center'> No results found.</td> </tr>";
                }

            ?>              

            </tbody>
</table>

</form>

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


<?php

if(isset($_GET['delete'])){
    $comment_id = escape($_GET['delete']);
    $post_id = escape($_GET['post_id']);
    $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
    $delete_query = mysqli_query($connection, $query);
    
      header("Location: post_comments.php?post_id=$post_id");
}


if(isset($_GET['approve'])){
    $comment_id = escape($_GET['approve']);
    $post_id = escape($_GET['post_id']);
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id}";
    $update_query = mysqli_query($connection, $query);
    
      header("Location: post_comments.php?post_id=$post_id");
}

if(isset($_GET['unapprove'])){
    $comment_id = escape($_GET['unapprove']);
    $post_id = escape($_GET['post_id']);
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id}";
    $update_query = mysqli_query($connection, $query);
    
      header("Location: post_comments.php?post_id=$post_id");
}


