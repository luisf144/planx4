<h1 class="page-header">
    Welcome to Admin
    <?php 
    $user_firstname = (isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] : "" );
    $user_lastname = (isset($_SESSION['user_lastname']) ? $_SESSION['user_lastname'] : "" );
    ?>

    <small><?php echo $user_firstname . " " . $user_lastname; ?></small>
</h1>