<script>
window.fbAsyncInit = function() {
    FB.init({
        appId      : '926107071182162',
        cookie     : true,
        xfbml      : true,
        version    : 'v5.0'
    });
        
    FB.AppEvents.logPageView();   

    addEventHandler(getNode("div.fb-login-button"),'click', function(){
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        }); 
    }) 
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function statusChangeCallback(response) {
    //Check Fb reponse status
    if (response.status === 'connected') {
        callFbAPI();
    }
}
(function operateModal() {
  // Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
})();
function callFbAPI() {
    //Request name, email, dob form Fb
    FB.api('me?fields=name,email,birthday', function(response) {
        var name = response.name.split(" ");

        getId('fbAuth').value = "true";
        getId('email2').value = response.email;
        getId('email3').value = response.email;
        getId('firstname').value = name.shift();
        getId('lastname').value = name.pop();
        getId('dob').value = response.birthday;
        getId('password2').value = "<?php echo $temp_password; ?>";
        getId('password3').value = "<?php echo $temp_password; ?>";

        setTimeout(function() {
        //Log out Fb before signing up to BBB
        FB.logout(function(response) {
            if (response.status !== 'connected') {
                getId('signupbtn').click();
            }
        });
        }, 0);
    }) 
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function validate_signup(){
    var fbAuth = getNode('input#fbAuth'),
        email2 = getNode('input#email2'),
        emailErr = getNode('td.errMsgTd#emailErr'),
        address = getNode('input#address'),
        addressErr = getNode('td.errMsgTd#addressErr'),
        city = getNode('input#locality'),
        cityErr = getNode('td.errMsgTd#cityErr'),
        state = getNode('input#administrative_area_level_1'),
        stateErr = getNode('td.errMsgTd#stateErr'),
        zip = getNode('input#postal_code'),
        zipErr = getNode('td.errMsgTd#zipErr'),
        country = getNode('input#country'),
        countryErr = getNode('td.errMsgTd#countryErr'),
        firstname = getNode('input#firstname'),
        firstnameErr = getNode('td.errMsgTd#firstnameErr'),
        lastname = getNode('input#lastname'),
        lastnameErr = getNode('td.errMsgTd#lastnameErr'),
        password2 = getNode('input#password2'),
        passwrodErr = getNode('td.errMsgTd#passwrodErr'),
        password3 = getNode('input#password3'),
        formErr = ''
    ;
    

    if (fbAuth.value == 'false') {
      // EMAIL
      if (!RegExp(/\S{2,}@\S{2,}\.\S{2,}/).test(email2.value) || email2.value.length < 5) {
        //If email contains 2+ non spaces,'@', 2+ non spaces,'.', 2+ non spaces
        formErr += '*Invalid e-mail address \n';
        email2.classList.add('yellow'); 
        emailErr.innerText = 'Please enter a valid email';
      } else {
          email2.removeClass('yellow');
          emailErr.innerText = '';
      }
      // FIRST NAME
      if (RegExp(/[^-\'a-zA-Z]+/).test(firstname.value) || firstname.value.length < 2) {
        //If name contains anyting other than -, ', or letters
        formErr += '*Invalid first name \n';
        firstname.classList.add('yellow');
        firstnameErr.innerText = 'Invalid first name';
      }else{
        firstname.removeClass('yellow');
        firstnameErr.innerText = '';
      }
      // LAST NAME
      if (RegExp(/[^-\'a-zA-Z]+/).test(lastname.value) || lastname.value.length < 2) {
        formErr += '*Invalid last name \n';
        lastname.classList.add('yellow');
        lastnameErr.innerText = 'Invalid last name';
      }else{
        lastname.removeClass('yellow');
        lastnameErr.innerText = '';
      }

      // ADDRESS
      if (RegExp(/\d{1,}\s\D\w{1,}\s\D\w{2,}/).test(address.value) || address.value.length < 2) {
        formErr += '*Please enter valid address \n';
        address.classList.add('yellow');
        addressErr.innerText = 'Please enter a valid address';
      }else{
        address.removeClass('yellow');
        addressErr.innerText = '';
      }
      // CITY
      if (city.value.length < 2 ) {
        formErr += '*Please enter valid city \n';
        city.classList.add('yellow');
        cityErr.innerText = 'Please enter a valid city';
      }else{
        city.removeClass('yellow');
        cityErr.innerText = '';
      }
      // STATE
      if (state.value.length !== 2) {
        formErr += '*Please enter valid state abbreviation \n';
        state.classList.add('yellow');
        stateErr.innerText = 'Please enter a valid state';
      }else{
        state.removeClass('yellow');
        stateErr.innerText = '';
      }
      // COUNTRY
      if (country.value.length < 2 ) {
        formErr += '*Please enter valid country \n';
        country.classList.add('yellow');
        countryErr.innerText = 'Please enter a valid country';
      }else{
        country.removeClass('yellow');
        countryErr.innerText = '';
      }
      // ZIP
      if (zip.value.length < 5 ) {
        formErr += '*Please enter a valid zip code\n';
        zip.classList.add('yellow');
        zipErr.innerText = 'Please enter a valid zip code';
      }else{
        zip.removeClass('yellow');
        zipErr.innerText = '';
      }
      // PASSWORD
      if (!password2.value || !password3.value) {
        formErr += '*Please enter and confirm password \n';
        password2.classList.add('yellow');
        password3.classList.add('yellow');
        passwordErr.innerText = 'Please enter and confirm password';
      } 
      else if (password2.value !== password3.value) {
        formErr += '*Password fields must contain same value \n';
        password2.value = '';
        password3.value = '';
        password2.classList.add('yellow');
        password3.classList.add('yellow');
        passwordErr.innerText = 'Password fields must contain same value';
      } 
      else if (!RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/).test(password2.value) || password2.value.length < 8 ) {
        formErr += '*Passwords must be at least 8 characters long and '+
                  'include one capital letter, one special character, and one number.\n';
        password2.classList.add('yellow');
        password3.classList.add('yellow');
        passwordErr.innerText = 'Passwords must be at least 8 characters long and '+
                  'include one capital letter, one special character, and one number.\n';
      } else {
        password2.removeClass('yellow');
        password3.removeClass('yellow');
        passwordErr.innerText = '';
      }

      if (formErr){
        formErr += '*Please revise all mandatory fields \n';  
        // getNode('div.formMsg div').innerText = formErr;
      } else {
        validateAddress();
      }
    } else {return true} 
}
</script>