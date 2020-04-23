<?php

if (!isset($connection)) {
    include "../includes/db.php";
}

if (!function_exists("confirm_query")) {
    include "../includes/functions.php";
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

global $post_id;
if(isset($_POST['post_id']) && isset($_POST['user_id']) && isset($_POST['liked'])){echo "entre;";

    $post_id  = $_POST['post_id'];
    $post_likes = $_POST['currentLiked'];
    $user_id = $_POST['user_id'];
    $liked = $_POST['liked'];

    if($liked === "yes"){
        $post_likes++;
        $sql_likes = "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)";
    }else{
        $post_likes--;
        $sql_likes = "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id";
    }
    echo $sql_likes;

    $query = "UPDATE posts SET post_likes = $post_likes WHERE post_id=$post_id";
    $exe_query = mysqli_query($connection, $query);
    confirm_query($exe_query);


    $exe_query = mysqli_query($connection, $sql_likes);
    confirm_query($exe_query);
}

$post_id = isset($_GET['post_id']) ? $_GET['post_id']: $_POST['post_id'];

if(isset($_GET['refresh_likes'])){
//    session_start();
    $post_likes = getPostLikes($_GET['post_id']);
}else{
    /* GETTING POST LIKES */
    $post_likes = getPostLikes(isset($_GET['post_id']) ? $_GET['post_id']: $_POST['post_id']);
    /* END */
}

?>

<div id="content-likes">

    <div class="like-section">


        <?php

        if(isset($_SESSION['user_id'])){

            ?>
            <div class="row">
                <p class="pull-left">
                    <a href="#" class="<?php echo (userLikedThePost($post_id, $_SESSION['user_id']) ? 'unlike':'like'); ?>"
                       data-id="<?php echo $post_id; ?>" data-likes="<?php echo $post_likes; ?>"
                       data-user-id="<?php echo $_SESSION['user_id']; ?>">
                        <span class="glyphicon glyphicon-thumbs-<?php echo (userLikedThePost($post_id, $_SESSION['user_id']) ? 'down':'up'); ?>"></span>
                        <?php echo (userLikedThePost($post_id, $_SESSION['user_id']) ? 'Unlike':'Like'); ?>
                    </a>
                </p>
            </div>


        <?php
        }else{

            ?>
            <div class="row">
                <p class="pull-left">
                    You need to
                    <a href="../index.php" >Login</a> to like.
                </p>
            </div>


        <?php
        }

        ?>



        <div class="row">
            <p class="pull-left">
                <strong>Likes</strong>:
                <span id="count-likes">
                <?php echo $post_likes; ?>
                    <i class="fa fa-heart" aria-hidden="true"></i>
            </span>
            </p>
        </div>

    </div>

</div>
