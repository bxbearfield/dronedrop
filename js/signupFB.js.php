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
        email3 = getNode('input#email3'),
        firstname = getNode('input#firstname'),
        lastname = getNode('input#lastname'),
        dob = getNode('input#dob'),
        password2 = getNode('input#password2'),
        password3 = getNode('input#password3'),
        formErr = ''
    ;
    

    if (fbAuth.value == 'false') {
      if (!RegExp(/\S{2,}@\S{2,}\.\S{2,}/).test(email2.value) || email2.value.length < 5) {
        //If email contains 2+ non spaces,'@', 2+ non spaces,'.', 2+ non spaces
        formErr += '*Invalid e-mail address \n';
        email2.classList.add('yellow');
        email3.classList.add('yellow');  
      } else {
          email2.removeClass('yellow');
          email3.removeClass('yellow');
      }
      
      if (email2.value !== email3.value) {
        formErr += '*Email fields must contain same value \n';
        if(!formErr) email2.classList.add('yellow');
        if(!formErr) email3.classList.add('yellow');
      }else if(!formErr){
        email2.removeClass('yellow');
        email3.removeClass('yellow');
      }

      if (RegExp(/[^-\'a-zA-Z]+/).test(firstname.value) || firstname.value.length < 2) {
        //If name contains anyting other than -, ', or letters
        formErr += '*Invalid first name \n';
        firstname.classList.add('yellow');
      }else{
        firstname.removeClass('yellow');
      }

      if (RegExp(/[^-\'a-zA-Z]+/).test(lastname.value) || lastname.value.length < 2) {
        formErr += '*Invalid last name \n';
        lastname.classList.add('yellow');
      }

      if (!RegExp(/^\d{2}\/\d{2}\/\d{4}$/).test(dob.value)) {
        //Regex: 2 digits, fwd slash, 2 digits, fwd slash, 4 digits
        formErr += '*Date must be in MM/DD/YYY format \n';
        dob.classList.add('yellow');
      }else{
        lastname.removeClass('yellow');
      }

      if (!password2.value || !password3.value) {
        formErr += '*Please enter and confirm password \n';
        password2.classList.add('yellow');
        password3.classList.add('yellow');
      } 
      else if (password2.value !== password3.value) {
        formErr += '*Password fields must contain same value \n';
        password2.value = '';
        password3.value = '';
        password2.classList.add('yellow');
        password3.classList.add('yellow');
      } 
      else if (!RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/).test(password2.value) || password2.value.length < 8 ) {
        formErr += '*Passwords must be at least 8 characters long and '+
                  'include one capital letter, one special character, and one number.';
        password2.classList.add('yellow');
        password3.classList.add('yellow');
      }else{
        password2.remoceClass('yellow');
        password3.remoceClass('yellow');
      }
      if (formErr){
        formErr += '*Please enter all mandatory fields \n';  
        getNode('div.formMsg div').innerText = formErr;
        return false
      } else {return true}
    } else {return true} 
}
</script>