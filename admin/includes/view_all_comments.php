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

            $query = "SELECT * FROM comments";
            $select_comments = mysqli_query($connection, $query);

             while($row = mysqli_fetch_assoc($select_comments)){
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

                 echo "<td> <a href='comments.php?approve={$comment_id}&comment_post_id={$comment_post_id}'>Approve</a> </td>";
                 echo "<td> <a href='comments.php?unapprove={$comment_id}&comment_post_id={$comment_post_id}'>Unapprove</a> </td>";
                 echo "<td> <a href='comments.php?delete={$comment_id}&comment_post_id={$comment_post_id}'>Delete</a> </td>";
                 echo "</tr>";
             }

            ?>              

            </tbody>
</table>




<?php

if(isset($_GET['delete'])){
    $comment_id = escape($_GET['delete']);
    $comment_post_id = escape($_GET['comment_post_id']);
    $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
    $delete_query = mysqli_query($connection, $query);
    
      header("Location: comments.php");
}


if(isset($_GET['approve'])){
    $comment_id = escape($_GET['approve']);
    $comment_post_id = escape($_GET['comment_post_id']);
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id}";
    $update_query = mysqli_query($connection, $query);
    
      header("Location: comments.php");
}

if(isset($_GET['unapprove'])){
    $comment_id = escape($_GET['unapprove']);
    $comment_post_id = escape($_GET['comment_post_id']);
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id}";
    $update_query = mysqli_query($connection, $query);
    
      header("Location: comments.php");
}


?>