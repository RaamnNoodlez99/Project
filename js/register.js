let isValidName = false;
let isValidSurname = false;
let isValidEmail = false;
let isValidBirth = false;
let isValidPassword = false;
let isValidSecondPassword = false;

let username = document.getElementById('regName');
let surname = document.getElementById('regSurname');
let email = document.getElementById('regEmail');
let bDay = document.getElementById('regBirthDate');
let password1 = document.getElementById('pass1');
let password2 = document.getElementById('pass2');
let button = document.getElementById('regSubmit');
let nameSpan = document.getElementById('nameSpan');
let surnameSpan = document.getElementById('surnameSpan');
let emailSpan = document.getElementById('emailSpan');
let bDaySpan = document.getElementById('dateSpan');
let passwordSpan = document.getElementById('passwordSpan');
let passwordSpan2 = document.getElementById('passwordSpan2');

email.onkeyup = function(){
    const regex = /^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,8}$/;
    const regexo = /^([\.\_a-zA-Z0-9]+)@([a-zA-Z]+)\.([a-zA-Z]){2,3}\.[a-zA-Z]{1,3}$/;
    if(regex.test(email.value) || regexo.test(email.value)){
        emailSpan.innerHTML = "";
        isValidEmail = true;
    }else{
        emailSpan.innerHTML = "Your email is invalid";
        isValidEmail = false;
    }
}

password1.onkeyup = function(){
    if(password1.value.length > 0){
        passwordSpan.innerHTML = "";
        isValidPassword = true;
        
    }else{
        passwordSpan.innerHTML = "Password is required";
        isValidPassword = false;
    }
}

password2.onkeyup = function(){
    if(password2.value == password1.value){
        passwordSpan2.innerHTML = "";
        isValidSecondPassword = true;
    }else{
        passwordSpan2.innerHTML = "Password does not much";
        isValidSecondPassword = false;
    }
}

button.onclick = function(){
    let returning = true;

    if(username.value.length > 0){
        nameSpan.innerHTML = "";
        isValidName = true;
    }else{
        nameSpan.innerHTML = "Name is required";
        isValidName = false;

        returning = false;
    }

    if(surname.value.length > 0){
        surnameSpan.innerHTML = "";
        isValidSurname = true;
    }else{
        surnameSpan.innerHTML = "Surname is required";
        isValidSurname = false;

        returning = false;
    }

    if(email.value.length > 0){
    }else{
        emailSpan.innerHTML = "Email is required";
        isValidEmail = false;

        returning = false;
    }

    if(bDay.value.length > 0){
        bDaySpan.innerHTML = "";
        isValidBirth = true;
    }else{
        bDaySpan.innerHTML = "Birthday is required";
        isValidBirth = false;

        returning = false;
    }

    if(password1.value.length > 0){
    }else{
        passwordSpan.innerHTML = "Password is required";
        isValidPassword = false;

        returning = false;
    }

    if(isValidName && isValidSurname && isValidEmail && isValidBirth && isValidPassword && isValidSecondPassword && returning){
        return true;
    }else{
        console.log(isValidName + isValidSurname + isValidEmail + isValidBirth + isValidPassword + isValidSecondPassword + returning);
        return false;
    }
}
