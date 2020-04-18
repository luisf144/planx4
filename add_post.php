<?php include "includes/header.php";  ?>
   
    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<?php 
$user_firstname = (isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] : "" );
$user_lastname = (isset($_SESSION['user_lastname']) ? " ".$_SESSION['user_lastname'] : "" );       
                
if(isset($_POST['create_post'])){ 
    $post_author = escape($_POST['post_author']); 
    $post_title = escape($_POST['post_title']); 
    $post_category_id = escape($_POST['post_category']); 
    $post_status = 'published';
    
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    
    $post_tags = escape($_POST['post_tags']); 
    $post_content = escape($_POST['post_content']); 
    $post_date = date('Y-m-d H:i:s');
    $post_created_by = $_SESSION['username'];
    
    move_uploaded_file($post_image_temp, "images/{$post_image}");
    
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status, post_created_by) ";
    
    $query .= " VALUES( '{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}', '{$post_created_by}' )";
    
    $create_post_query = mysqli_query($connection, $query);
    
    confirm_query($create_post_query);
    header("Location: index.php");
}

?>


<!-- Page Content -->
<div class="container">   
<h1 class="page-header">
     New Post
</h1>
                                                        
<form action="" method="post" enctype="multipart/form-data">
                                
    <div class="form-group">
    <label for="post_title"> Post Title</label>
        <input type="text" class="form-control" name="post_title">    
    </div>
    
    
    <div class="form-group">
    
       <label for="post_category"> Post Category</label>
       <br>
        <select name="post_category" id="">
            
        <?php 
        $query = "SELECT * FROM categories"; 
        $select_categories = mysqli_query($connection, $query);    

         while($row = mysqli_fetch_assoc($select_categories)){
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
             
            echo "<option value='$cat_id' > {$cat_title} </option>";

         }
        ?>    
                    
            
        </select>
    
    </div>

   
    <div class="form-group">
    <label for="post_author"> Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $user_firstname.$user_lastname; ?>" readonly="readonly">    
    </div>
    
    <div class="form-group">
    <label for="post_image"> Post Image</label>
        <input type="file" name="post_image">    
    </div>

   
    <div class="form-group">
    <label for="post_tags"> Post Tags</label>
        <input type="text" class="form-control" name="post_tags">    
    </div>
    
    
    <div class="form-group">
    <label for="post_content"> Post Content</label>
        <textarea id="body" type="text" class="form-control" name="post_content" cols="30" rows="10"></textarea>  
    </div>
    
   
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
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

<!-- Footer -->
<?php include "includes/footer.php"; ?>  
