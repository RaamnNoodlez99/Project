$(document).ready(() => {
    //viweing users profiles//
    let userProfiles = document.getElementsByClassName('friend-box');
    let myID = $('#myUid').val();

    for(let i=0; i<userProfiles.length; i++){
        let userProfile = userProfiles[i];

        let numb = userProfile.getAttribute('id').match(/\d/g);
        numb = numb.join("");
        let userID = numb;

        userProfile.onclick = function(){  
            if(userID == myID){
                window.location.href = "profile.php";  
            }else{
                window.location.href = "displayProfile.php?id=" + userID;
            }
        }
    }
});