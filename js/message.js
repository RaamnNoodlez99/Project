$(document).ready(() => {
  let inputBox = $('#inputBox');
  let sendBtn = $('#sendButton');
  let friendId = $('#friendHidden').val();

  let profilePictureURL = $('#profilePictureURL').val();
  let profilePictureDisplay = $('#profilePictureDisplay').val();
  let defaultProfilePicture = $('#defaultProfilePicture').val();
  let friendImage = $('#friendImage').val();
  let setFriendImage = $('#setFriendImage').val();
  let defaultFriendImage = $('#defaultFriendImage').val();

  sendBtn.click(() => {
    let msg = inputBox.val();
    
    const timeOfMsg = new Date().toISOString().slice(0, 19).replace('T', ' ');
    inputBox.val('');


    if(msg != ''){
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'messages/sendMessage.php',
        data: {"msg": msg,
              "time": timeOfMsg,
              "friendId": friendId},
        success:function(ret){
          
          if(ret.success == 'true'){
            $.ajax({
              type: 'post',
              dataType: 'json',
              url: 'messages/checkLastMessage.php',
              data: {},
              success:function(data){
                

                if(data.outgoing_id != friendId){
                  $('#messageArea').append(
                    $('<div></div>', {
                      class: 'my-msg-wrapper',
                    }).append(
                      $('<div></div>', {
                        html: data.message,
                        class: 'my-msg'
                      }),
                      $('<div></div>', {
                        class: 'friend-img-side'
                      }).append(
                        $('<img/>', {
                          src: profilePictureURL,
                          alt: 'profile-picture',
                          style: 'display:' + profilePictureDisplay
                        }),
                        $('<i></i>', {
                          class: 'fa-solid fa-user',
                          style: 'display:' + defaultProfilePicture
                        })
                      ),
                      $('<span></span>', {
                        class: 'msg-time',
                        html: data.timestamp
                      })
                    )
                  )
                }else if(data.incoming_id != friendId){
                  $('#messageArea').append(
                    $('<div></div>', {
                      class: 'their-msg-wrapper',
                    }).append(
                      $('<div></div>', {
                        class: 'friend-img-side'
                      }).append(
                        $('<img/>', {
                          src: friendImage,
                          alt: 'profile-picture',
                          class: setFriendImage
                        }),
                        $('<i></i>', {
                          class: 'fa-solid fa-user ' + defaultFriendImage 
                        })
                      ),
                      $('<div></div>', {
                        html: data.message,
                        class: 'their-msg'
                      }),
                      $('<span></span>', {
                        class: 'msg-time',
                        html: data.timestamp
                      })
                    )
                  )
                }
                
                let objDiv = document.getElementById("messageArea");
                objDiv.scrollTop = objDiv.scrollHeight;


              }
            })
          }
        }
      })
    }

  });

  $(document).keypress((e) => {
    let key = e.which;

    if(key == 13){
      sendBtn.click();
      return false;
    }
  })
})