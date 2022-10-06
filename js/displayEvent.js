$(document).ready(() => {
    let rating = $('#rating');
    let eID = $('#eID').val();
    let myID = $('#myID').val();

    let likeButton = $('#likeButton');
    let unlikeButton = $('#unlikeButton');
    let likeHeart = $('#likeHeart');
    let unlikeHeart = $('#unlikeHeart');

    let like = false;

    likeButton.click(() => {
        like = true;
        rating.val('like');

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'eventInfo/setRating.php',
            data: {"like": like,
                    "eventID": eID,
                    "myID": myID},
            success:function(data){
                    // alert(data.success);
                    // location.reload();
            }
        });

        likeButton.addClass('liked');
        likeHeart.addClass('liked');
        unlikeButton.removeClass('unliked');
        unlikeHeart.removeClass('unliked');
    })

    unlikeButton.click(() => {
        like = false;
        rating.val('unlike');

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'eventInfo/setRating.php',
            data: {"like": like,
                    "eventID": eID,
                    "myID": myID},
            success:function(data){
                    // alert(data.success);
                    // location.reload();
            }
        });

        unlikeButton.addClass('unliked');
        unlikeHeart.addClass('unliked');
        likeButton.removeClass('liked');
        likeHeart.removeClass('liked');
    })


});