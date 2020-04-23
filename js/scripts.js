$(document).ready(function(){
    bindLikeFuncionality();

    changeLanguage();

    navResponsive();

    loadUsersOnline();
    
    setInterval(function(){
        loadUsersOnline();
    }, 10000);

});

function changeLanguage(){
    $("#language_select").change(function () {
        $('#language_form').submit();
    });
}

function navResponsive(){
    var innerWidth = window.innerWidth;
    if(innerWidth < 1000){
        document.getElementById("liLogin").style.display = "block";
        document.getElementById("liRegister").style.display = "block";
    }
}

function loadUsersOnline(){
    $.get("includes/functions.php?onlineusers=result", function(data){
        $(".users-online").text(data);
    })
};

function postLikes(instanceThis, userLikedIt){
    var postId = $(instanceThis).attr("data-id");
    var currentLiked = $(instanceThis).attr("data-likes");
    var userId = $(instanceThis).attr("data-user-id");

    $.ajax({
        url: "includes/likes.php",
        type: "post",
        data: {
            liked: userLikedIt,
            currentLiked: currentLiked,
            post_id: postId,
            user_id: userId
        },
        success: successCallBackFun
    });

    function successCallBackFun(data){
        $.get("includes/likes.php?refresh_likes=true&post_id="+postId, function(data){


            $(".like-section").remove();

            $("#content-likes").html(data);
            bindLikeFuncionality();

        });
    }
}


function bindLikeFuncionality(){
    $(".like").click(function(e){
        e.preventDefault();

        postLikes(this, "yes");
        return false;

    });

    $(".unlike").click(function(e){
        e.preventDefault();

        postLikes(this, "no");
        return false;
    });
}


