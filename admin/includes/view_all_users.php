 <table class="table table-bordered hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Online</th>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>

            <?php 

            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);
            $users_online = get_users_online();
             
            while($row = mysqli_fetch_assoc($select_users)){
                $user_id = $row['user_id']; 
                $username = $row['username']; 
                $user_firstname = $row['user_firstname']; 
                $user_lastname = $row['user_lastname']; 
                $user_email = $row['user_email']; 
                $user_role = $row['user_role']; 
                $user_image = $row['user_image'];  
                $user_is_online = false;
                 
                 if(in_array($user_id, $users_online)){
                       $user_is_online = true;  
                 }
                 
                 echo "<tr>";
                 echo "<td> $user_id </td>";
            
                 echo "<td class='text-center'><i class='fa fa-circle' ". (($user_is_online) ? " style='color:limegreen'" : " style='color:red'") ." ></i></td>";
                 echo "<td> $username </td>";
                 echo "<td> $user_firstname </td>";
                 echo "<td> $user_lastname </td>";
                 
                 
//                $query = "SELECT * FROM posts WHERE post_id = {$user_post_id}";
//                $select_post_id = mysqli_query($connection, $query);
//
//                while($row = mysqli_fetch_assoc($select_post_id)){
//                    $post_id = $row['post_id'];
//                    $post_title = $row['post_title'];
//
//                    echo "<td> <a href='../post.php?post_id=$post_id'>$post_title</a> </td>";
//                 }
                 
                 echo "<td> $user_email </td>";
                 echo "<td> $user_role </td>";
                 echo "<td> $user_image </td>";

                 echo "<td> <a href='users.php?source=edit_user&user_id={$user_id}'>Edit</a> </td>";

            ?>

                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <td>
                        <button type="submit" class="btn btn-link" name="delete_user">Delete</button>
                    </td>
                </form>


            <?php
                 echo "</tr>";
             }

            ?>              

            </tbody>
</table>




<?php

if(isset($_POST['delete_user'])){
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE user_id = {$user_id}";
    $delete_query = mysqli_query($connection, $query);
      header("Location: users.php");
}




?>