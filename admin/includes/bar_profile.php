<?php 

if(isset($_GET['logout'])){
    unset( $_SESSION['user_id']);
    unset( $_SESSION['username']);
    unset( $_SESSION['user_firstname']);
    unset( $_SESSION['user_lastname']);
    unset( $_SESSION['user_role']);
    
    header("Location: index.php");
}

if(isset($_SESSION['username'])){
    
$user_firstname = $_SESSION['user_firstname'];
$user_lastname = $_SESSION['user_lastname'];
$fullname = $user_firstname . " " . $user_lastname;

?>

<li class="dropdown" >
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-user"></i> 
<?php echo $fullname ?> <b class="caret"></b>
</a>
<ul class="dropdown-menu">
    <li>
        <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
    </li>

    <li class="divider"></li>
    <li>
        <a href="?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
    </li>
</ul>
</li>   
    
<?php } ?>   