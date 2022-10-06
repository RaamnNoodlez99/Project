$(document).ready(() => {
    let addView = false;
    let addButton = document.getElementById('add-event-button');
    let addForm = document.getElementById('eventForm');
    let exitButton = document.getElementById('exit');
    
    let addOrEditHeading = document.getElementById('addOrEditHeading');
    let addOrEditButton = document.getElementById('addSubmit');
    let addOrEditForm = document.getElementById('addOrEditForm');
    let editNumber = document.getElementById('editNumber');
    
    let addName = document.getElementById('name');
    let addDescription = document.getElementById('description');
    let addDate = document.getElementById('date');
    let addLocation = document.getElementById('location');
    let addHashtags = document.getElementById('hashtags');
    let addImage = document.getElementById('currentImage');
    
    if(addView == false){
        addForm.classList.remove('show');
        addForm.classList.add('hide');
        addView = true;
    }
    
    function changeView(){
        if(addView == false){
            addForm.classList.remove('show');
            addForm.classList.add('hide');
            addView = true;
        }else{
            addForm.classList.remove('hide');
            addForm.classList.add('show');
            addView = false;
        }
    }
    
    addButton.onclick = function(){
        changeView();
    
        addOrEditHeading.innerText = "Add an artwork";
        addOrEditButton.innerText = "Add Artwork";
    
        addName.value = "";
        addDescription.value = "";
        addDate.value = "";
        addLocation.value = "";
        addHashtags.value = "";
        addOrEditForm.value = "add";
        editNumber.value = "-1";
        addImage.style.display = "none";
    }
    
    exitButton.onclick = function(){
        changeView();
    }
    
    //edit button functionality
    function edit(){
        changeView();

        addOrEditHeading.innerText = "Edit an artwork";
        addOrEditButton.innerText = "Edit Artwork";
        addOrEditForm.value = "edit";
    }
    
    let editButtons = document.getElementsByClassName('edit-event-button');
    
    for(let i=0; i<editButtons.length; i++){
        let editButton = editButtons[i];
    
        editButton.onclick = function(){
            edit();
            
            let txt = editButton.id;

            var numb = txt.match(/\d/g);
            numb = numb.join("");

            let tempNum = numb;

            let oldName = "eName-" + tempNum;
            let oldDesc = "eDescription-" + tempNum;
            let oldDate = "eDate-" + tempNum;
            let oldLocation = "eLocation-" + tempNum;
            let oldHashtags = "div#eHashtags-" + tempNum + " .eHashtag";
            let oldImage = "eImage-" + tempNum;

            editNumber.value = "" + tempNum;
    
            addName.value = document.getElementById(oldName).innerText;
            addDescription.value = document.getElementById(oldDesc).innerText;
            addDate.value = document.getElementById(oldDate).innerText;
            addLocation.value = document.getElementById(oldLocation).innerText;
    
            let tempHashtags = $(oldHashtags);
            let hashTagString = "";
    
            for(let j=0; j<tempHashtags.length; j++){
                hashTagString += tempHashtags[j].innerText + " ";
            }
    
            addHashtags.value = hashTagString;
            
            addImage.style.display = "block";
            oldImage = document.getElementById(oldImage).src;
            oldImage = oldImage.split('/').pop();
            addImage.innerText = "Currently uploaded image: " + oldImage;
        }
    }
    //edit button end

    //local and global feeds//
    /*edit relationship*/
    let feedType = $('#feedType');

    feedType.change(() => {
        let feedTypeText = feedType.find(":selected").text();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'feedCheck.php',
            data: {"feedTypeText": feedTypeText},
            success:function(data){
                if(data.success == 'true'){
                    location.reload();
                }
            }
        })
    });
    /*edit relationship end*/
    //end//

    //clicking on an event//
    let events = document.getElementsByClassName('eName');

    for(let i=0; i<events.length; i++){
        let singleEvent = events[i];

        singleEvent.onclick = function(){

            let numb = singleEvent.getAttribute('id').match(/\d/g);
            numb = numb.join("");

            let eventID = numb;

            window.location.href = "displayEvent.php?id=" + eventID;
        }
    }
    //end//
})