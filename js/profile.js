$(document).ready(() => {
    let editSpan = $('#editSpanShow');
    let profileImageDiv = $('.profile-image');
    let uploadInput =  $('#profileToUpload');
    let cropTool = $('.crop-image-tool');
    let cropImage = document.getElementById('sampleImage');
    let exitCropTool = $('#exit');
    let cropButton = $('#cropButton');
    let cropper;

    profileImageDiv.mouseenter(() => {
        editSpan.css("visibility", "visible");
    });

    profileImageDiv.mouseleave(() => {
        editSpan.css("visibility", "hidden");
    });

    profileImageDiv.click(() => {
        uploadInput.trigger('click');
    });

    exitCropTool.click(() => {
        cropTool.css("display", "none");
        cropper.destroy();
        cropper = null;
    });

    function hideModal(){
        cropTool.css("display", "none");
        cropper.destroy();
        cropper = null;
    }

    cropTool.css("display", "none");

    uploadInput.change((event) => {
        let files = event.target.files;

        let done = (url) => {
            cropImage.src = url;
            cropTool.css("display", "flex");

            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.cropped-image-preview'
            });
        }

        if(files && files.length > 0){
            reader = new FileReader();

            reader.onload = (event) => {
                done(reader.result);
            };

            reader.readAsDataURL(files[0]);
        }
    });

    cropButton.click(() => {
        let canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400
        });

        canvas.toBlob((blob) => {
            let url = URL.createObjectURL(blob);
            let reader = new FileReader();
            reader.readAsDataURL(blob);

            reader.onloadend = () => {
                let base64data = reader.result;

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'profileImage.php',
                    data: {cropImage:base64data},
                    success:function(data){
                        hideModal();
                        $('#uploaded-image').css("display", "block");
                        $('#uploaded-image').attr("src", data);
                        
                        $('#hiddenProfileImage').val(data);
                        $('#dbForm').submit();
                    }
                })
            };
        });
    });

    /*edit about me*/
    let aboutMe = $('#aboutMe');

    aboutMe.click(() => {
        $('.tooltipstext').css('display', 'none');
    });

    aboutMe.blur(() => {
        $('.tooltipstext').css('display', 'block');
        let aboutMeText = aboutMe.clone().children().remove().end().text();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'userInfo/aboutMe.php',
            data: {"about": aboutMeText},
            // success:function(data){
            //     // alert(data.success);
            // }
        })
    });
    /*edit about me end*/

    /*edit work*/
    let work = $('#workProfile');

    work.click(() => {
        $('.tooltipstext').css('display', 'none');
    });

    work.blur(() => {
        $('.tooltipstext').css('display', 'block');
        let workText = work.clone().children().remove().end().text();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'userInfo/work.php',
            data: {"work": workText},
            // success:function(data){
            //     // alert(data.success);
            // }
        })
    });
    /*edit work end*/

    /*check relationship on page load*/
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'userInfo/checkRelationship.php',
        // data: {"work": workText},
        success:function(data){
            let value = data.success;
            if(data.success == 'Its complicated'){
                value = 'complicated';
            }else if(data.success == 'Rather not say'){
                value = 'ratherNotSay';
            }

            $('#relationshipProfile option[value=' + value +']').attr('selected','selected');
        }
    })
    /* end check relationship on page load */

    /*edit relationship*/
    let relationship = $('#relationshipProfile');

    relationship.change(() => {
        let relationshipText = relationship.find(":selected").text();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'userInfo/relationship.php',
            data: {"relationship": relationshipText},
            // success:function(data){
            //     // alert(data.success);
            // }
        })
    });
    /*edit relationship end*/

    /*edit email*/
    let email = $('#emailProfile');
    let oldEmail = $('#emailProfile').val();

    email.click(() => {
        email.removeClass('errorEmail');
    })

    email.change(() => {
        let emailText = email.val();

        const regex = /^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,8}$/;
        const regexo = /^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,3}\.[a-zA-Z]{1,3}$/;
        if(regex.test(emailText) || regexo.test(emailText)){
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'userInfo/email.php',
                data: {"email": emailText},
                // success:function(data){
                //     // alert(data.success);
                // }
            })
        }else{
            email.addClass('errorEmail');
            email.val('Invalid email Address!');
            email.css('color', '#dc3545');
            setTimeout(() => {
                email.val(oldEmail);
                email.css('color', 'white');
            }, 2000);
        }
    });
    /*edit email end*/

    // uploadInput.on('change', () => {
    //     $('#profileImageForm').submit();
    // });

    // const image = document.getElementById('testImage');
    // const cropper = new Cropper(image, {
    // aspectRatio: 16 / 9,
    // crop(event) {
    //     console.log(event.detail.x);
    //     console.log(event.detail.y);
    //     console.log(event.detail.width);
    //     console.log(event.detail.height);
    //     console.log(event.detail.rotate);
    //     console.log(event.detail.scaleX);
    //     console.log(event.detail.scaleY);
    // },
    // });

    //viweing users profiles//
    let userProfiles = document.getElementsByClassName('friend-box');

    for(let i=0; i<userProfiles.length; i++){
        let userProfile = userProfiles[i];

        userProfile.onclick = function(){

            let numb = userProfile.getAttribute('id').match(/\d/g);
            numb = numb.join("");

            let userID = numb;

            window.location.href = "displayProfile.php?id=" + userID;
        }
    }
});