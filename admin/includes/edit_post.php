<?php 
$alertDisplay = "none";
$alertContent = "Post updated successfully!";

if(isset($_GET['post_id'])){
    $post_id = escape($_GET['post_id']);
    $alertLinkTo = "<a href='../post.php?post_id=$post_id' class='alert-link'>View Post</a>";
 
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_posts_by_id = mysqli_query($connection, $query);

     while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_author = $row['post_author']; 
        $post_title = $row['post_title']; 
        $post_category_id = $row['post_category_id']; 
        $post_status = $row['post_status']; 
        $post_image_db = $row['post_image']; 
        $post_tags = $row['post_tags']; 
        $post_date = $row['post_date'];        
        $post_content = $row['post_content'];        

     }
    
    if(isset($_POST['update_post'])){
        $post_author = escape($_POST['post_author']); 
        $post_title = escape($_POST['post_title']); 
        $post_category_id = escape($_POST['post_category']); 
        $post_status = escape($_POST['post_status']);

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = escape($_POST['post_tags']); 
        $post_content = escape($_POST['post_content']); 
        

        move_uploaded_file($post_image_temp, "../images/{$post_image}");

        
        if(empty($post_image)){
            $post_image = $post_image_db;
        }
        
        $query = "UPDATE posts SET ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_date = now(), ";
        $query .= "post_image = '{$post_image}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_status = '{$post_status}' ";
        $query .= " WHERE post_id = {$post_id}";

        $update_post_query = mysqli_query($connection, $query);
        confirm_query($update_post_query);
        $alertDisplay = "block";
    }
        
        
    }
 
?>
                               
<div style="display: <?php echo $alertDisplay; ?>" class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong><?php echo $alertContent; ?></strong> <?php echo $alertLinkTo; ?> 
</div>

<form action="" method="post" enctype="multipart/form-data">
                                
    <div class="form-group">
    <label for="post_title"> Post Title </label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title ?>">    
    </div>
    
    
    <div class="form-group">
        <label for="post_category"> Post Category</label>
        <br>
        <select name="post_category" id="">
            
        <?php 
        $query = "SELECT * FROM categories"; 
        $select_categories = mysqli_query($connection, $query);
        confirm_query($select_categories);       

         while($row = mysqli_fetch_assoc($select_categories)){
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
             
            if($post_category_id == $cat_id)
                 echo "<option value='$cat_id' selected> {$cat_title} </option>";
             else
                 echo "<option value='$cat_id' > {$cat_title} </option>";

         }
        ?>    
                    
            
        </select>
    
    </div>

   
    <div class="form-group">
    <label for="post_author"> Post Author</label>
        <input type="text" class="form-control" name="post_author"   value="<?php echo $post_author ?>">    
    </div>
    
   <div class="form-group">
       <label for="post_status"> Post Status</label>
       <br>
        <select name="post_status" id="">

            <?php 
            $status = ['draft' => 'Draft', 'published' => 'Published'];
            foreach($status as $key => $state){
             
                echo "<option value='$key' ". ($post_status == $key ? 'selected' : '') . '>'; 
                echo $state;
                echo "</option>";
            }          
            
            ?> 
        </select> 
    </div>
    
    
    <div class="form-group">
        <label for="post_image"> Post Image</label>
        <br/>

        <img width="100" src="../images/<?php echo $post_image_db ?>" alt="image">     
        
        <input type="file" name="post_image">    
    </div>

   
    <div class="form-group">
    <label for="post_tags"> Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags ?>">    
    </div>
    
    
    <div class="form-group">
    <label for="post_content"> Post Content</label>
        <textarea id="body" type="text" class="form-control" name="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>  
    </div>
    
   
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>

</form>


<script>
ClassicEditor
        .create( document.querySelector( '#body' ),{    
        toolbar: [ 'Heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
        } )
        .catch( error => {
            console.error( error );
        } );
    
</script>