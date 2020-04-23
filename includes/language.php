<?php

// Setting Language Variables
if(isset($_GET['lang']) && !empty($_GET['lang'])){

    $_SESSION['lang'] = $_GET['lang'];

    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){

        echo "<script type='text/javascript'> location.reload(); </script>";

    }

}

if(isset($_SESSION['lang'])){

    include "languages/".$_SESSION['lang'].".php";

} else {

    include "languages/en.php";

}

?>
<!--media query top and right-->
<div class="container-lang">
    <form method="get" class="navbar-form navbar-right" action="" id="language_form">
        <div class="form-group">
            <select id="language_select" name="lang" class="form-control">
                <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?>>English</option>
                <option value="es" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'es'){ echo "selected"; } ?>>Spanish</option>
            </select>
        </div>
    </form>
</div>