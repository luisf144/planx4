<?php 

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
}

?>
       
       <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img class="logo-nav" alt="logo" src="images/logo.png"> 
                </a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                       
                    <?php 
                    $query = "SELECT * FROM categories LIMIT 3";
                    $select_all_categories_query = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_assoc($select_all_categories_query)){
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        
                        echo "<li> <a href='category.php?category_id=$cat_id'> {$cat_title} </a> </li>";
                    }
                    
                    ?>
                    
                    
                    <?php 
                    
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == "admin"){
                    ?>    
                       
                        <li>
                            <a href="admin"><b>Admin</b></a>
                        </li>

                        <li><a href="./admin/users.php">Users online: <span class="users-online"></span></a></li>
                    
                    <?php } ?>
                    
                    
                    <!--     if logged       -->
                    <?php 
                    
                    if(isset($_SESSION['username'])){
                    ?>  
                    
                        <li class="user-link">
                            <a href="./profile.php">
                                <i class="fa fa-fw fa-user"></i> Profile
                            </a>
                        </li>


                        <li class="user-link">
                            <a href="?logout">
                                <i class="fa fa-fw fa-power-off"></i> Log Out
                            </a>
                        </li>
                    
                    <?php } ?>
                    <!--     End                -->
                   
                   
                   
                    <li id="liLogin" style="display: none">    
                        <a href="#login" id="loginLink"><b><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Login</b></a>
                    </li>
                    <li id="liRegister" style="display: none">
                        <a href="#registration"><b><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp; Register</b></a>
                    </li>
               
                </ul>
                
                
                
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
   
<script type="text/javascript" >
  var innerWidth = window.innerWidth;
    if(innerWidth < 1000){
        document.getElementById("liLogin").style.display = "block";   
        document.getElementById("liRegister").style.display = "block";   
    }  
</script>