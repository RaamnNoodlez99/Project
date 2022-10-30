$(document).ready(() => {
    //viweing users profiles//
    let userProfiles = document.getElementsByClassName('friend-box');

    for(let i=0; i<userProfiles.length; i++){
        let userProfile = userProfiles[i];

        let numb = userProfile.getAttribute('id').match(/\d/g);
        numb = numb.join("");
        let userID = numb;

        userProfile.onclick = () => {  
            window.location.href = "displayProfile.php?id=" + userID;
        }
    }
    ///////////////

    //accempting friend request:
    let accBtns = document.getElementsByClassName('accBtnClass');
    let rejBtns = document.getElementsByClassName('rejBtnClass');

    for(let i=0; i<accBtns.length; i++){
        let accBtn = accBtns[i];

        accBtn.onclick = (event) => {
            let requestId = accBtn.id;

            requestId = requestId.replace( /^\D+/g, '');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'userInfo/acceptReq.php',
                data: {"requestId": requestId},
                success:function(data){
                    window.location.search = '?friend=added';
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    alert(msg);
                },
            })

            event.stopPropagation(); 
        }
    }

    for(let i=0; i<rejBtns.length; i++){
        let rejBtn = rejBtns[i];

        rejBtn.onclick = (event) => {
            let requestId = rejBtn.id;
            requestId = requestId.replace( /^\D+/g, '');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'userInfo/rejectReq.php',
                data: {"requestId": requestId},
                success:function(data){
                    window.location.search = '?friend=rejected';
                }
            })

            event.stopPropagation(); 
        }
    }
});