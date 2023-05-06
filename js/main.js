let password = document.getElementById("password");
let passwordStrength = document.getElementById("password-strength");
var passwordFormat = document.querySelector(".pass-format-list");
let lowUpperCase = document.querySelector(".low-upper-case i");
let number = document.querySelector(".one-number i");
let specialChar = document.querySelector(".one-special-char i");
let eightChar = document.querySelector(".eight-character i");


password.addEventListener("keyup", function(){
    let pass = document.getElementById("password").value;
  checkStrength(pass);
});

password.addEventListener("focus", function(){
    passwordFormat.classList.add("show");
})


// password hidden and visibility 
function toggle(id){
let element = document.getElementById(id);
element.getAttribute("type")==="password" ? element.setAttribute("type","text"):element.setAttribute("type","password");
// if(element.getAttribute("type")==="password"){
//     element.setAttribute("type","text");
// }else{
//     element.setAttribute("type","password");
// }
}

function show(show){
    show.classList.toggle("fa-eye-slash");
}



function checkStrength(password) {
    let strength = 0;

    //If password contains both lower and uppercase characters
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 1;
        lowUpperCase.classList.remove('fa-circle');
        lowUpperCase.classList.add('fa-check');
    } else {
        lowUpperCase.classList.add('fa-circle');
        lowUpperCase.classList.remove('fa-check');
    }
    //If it has numbers and characters
    if (password.match(/([0-9])/)) {
        strength += 1;
        number.classList.remove('fa-circle');
        number.classList.add('fa-check');
    } else {
        number.classList.add('fa-circle');
        number.classList.remove('fa-check');
    }
    //If it has one special character
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
        specialChar.classList.remove('fa-circle');
        specialChar.classList.add('fa-check');
    } else {
        specialChar.classList.add('fa-circle');
        specialChar.classList.remove('fa-check');
    }
    //If password is greater than 7
    if (password.length > 7) {
        strength += 1;
        eightChar.classList.remove('fa-circle');
        eightChar.classList.add('fa-check');
    } else {
        eightChar.classList.add('fa-circle');
        eightChar.classList.remove('fa-check');   
    }

    // If value is less than 2
    if (strength < 2) {
        passwordStrength.classList.remove('progress-bar-warning');
        passwordStrength.classList.remove('progress-bar-success');
        passwordStrength.classList.add('progress-bar-danger');
        passwordStrength.style = 'width: 10%';
    } else if (strength == 3) {
        passwordStrength.classList.remove('progress-bar-success');
        passwordStrength.classList.remove('progress-bar-danger');
        passwordStrength.classList.add('progress-bar-warning');
        passwordStrength.style = 'width: 60%';
    } else if (strength == 4) {
        passwordStrength.classList.remove('progress-bar-warning');
        passwordStrength.classList.remove('progress-bar-danger');
        passwordStrength.classList.add('progress-bar-success');
        passwordStrength.style = 'width: 100%';
    } 

document.getElementById("strength").value=strength;
console.log(document.getElementById("strength").value);

}

















// the next script use to sign by personal google account for user

// it not work because you document,t have a domain  
// use this link after get domain 
// https://console.cloud.google.com/apis/credentials?project=seventh-chassis-383803

// function onSignIn(googleUser) {  
//     // Get the user's ID token and send it to your server to authenticate the user
//     var id_token = googleUser.getAuthResponse().id_token;
  
//     // Redirect the user to your registration form
//     window.location.href = "https://your-registration-form.com?token=" + id_token;
//   }
  