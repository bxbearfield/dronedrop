window.onload = initPage;
var tabContent;

function initPage() {	
	var sideTabs = getId("leftCol").getElementsByClassName("leftColItem");

	//Editprofile Request new tab, close previous tab
	for (var i=0; i<sideTabs.length; i++) {
		var displayTab = sideTabs[i];
		addEventHandler(displayTab, 'click', getTabContent);
		addEventHandler(displayTab, 'click', updateTabDisplay);
	}

	//Display editprofile tabs
	if(igCode || igAdd){sideTabs[2].click()}
	else{sideTabs[0].click();}

	//Navigate editprofile tab panes for different urls
	setTimeout(function(){
		picAdd ? getId('settingsAnchor_picture').click() : '';
		igAdd ? getId('settingsAnchor_igDisplay').click() : '';
	}, 100);

	//Alert new users success from fb quick log in 
	setTimeout(function() {
		if (fblogin ){
			alert('Welcome to Bikini Bottom Buddies! You have completed express sign-'+
			'up through Facebook and can now edit your profile. \n\n'+
			'Please update your password. An e-mail has been sent with your automated password that '+
			'will expire in 30 days. \n\nClick'+
			' the tabs on the left to add your photo and Instagram feed or'+
			' click \'My Profile\' in the navigation menu to view '+
			'your profile and chat now!');
			sideTabs[1].click();
			setTimeout(function() {getId('settingsAnchor_password').click()},300);
		}else if (verified) {
			alert('Welcome to Bikini Bottom Buddies! You have completed sign-'+
			'up and can now edit your profile. \n\n'+
			'Click the tabs on the left to add your photo and Instagram feed or'+
			' click \'My Profile\' in the navigation menu to view '+
			'your profile and chat now!');
		}
	},400);
}	

function updateTabDisplay(e){
	//Toggle highlight on left column links
	var sideTabs =  
		getId("leftCol").getElementsByClassName("leftColItem");
	var me = getActivatedObject(e);
	
	for (var i=0; i<sideTabs.length; i++) {
		var displayTab = sideTabs[i];
		if(displayTab.id === me.id ) {
			me.classList.add('selected');
		}else{
			displayTab.removeClass('selected');
		}
	}
}

function getTabContent(e) {
	//Ajax request for edit profile tabs
	var me = getActivatedObject(e);
	var tabName = me.id;
	var tabRequest = createRequest();
	var url= "js/leftColTabs/" + escape(tabName) + "Info.php";
	
	if (tabRequest==null) {
		alert ("Unable to create request.");
		return;
	} 
	tabRequest.onreadystatechange = function() {displayDetails(tabRequest)};
	tabRequest.open("GET", url, true);
	tabRequest.send(null);	
	
}
	
function displayDetails(tabRequest) {
	if (tabRequest.readyState == 4 && tabRequest.status == 200) {
		tabContent = getId("tabContent");
		var data = JSON.parse(tabRequest.responseText);
		var htmlStr = "";
		var clsdPanes;
		
		for (i=0; i < data.length; i++) {
			var title = data[i].title;
			var value = data[i].value;
			var fileExt = data[i].form.file; 
			
			htmlStr += '<li class="settingsListItem" id="settingsLi_' + fileExt + '" title="Edit ' + title + '">';
			htmlStr += 		'<a href="#" class="settingsAnchor" id="settingsAnchor_' + fileExt + '" title="Edit ' + title + '">';
			htmlStr += 			'<h4 class="pane" title="Edit ' + title + '"> ' + title + '</h4>';
			htmlStr += 			'<span class="settingsChange" title="Edit ' + title + '">Edit</span>';
			htmlStr += 			'<span class="settingsDisplay" title="Edit ' + title + '">'+ value +'</span>';
			htmlStr += 		'</a>';
			htmlStr += '</li>';
		}
		tabContent.innerHTML = '<ul>'+htmlStr+'</ul>';
		clsdPanes = getId("tabContent").querySelectorAll("a.settingsAnchor");

		for (var i=0; i<clsdPanes.length; i++) {
			var clsdPane = clsdPanes[i];
			addListeners(clsdPane, data[i]);
		}
	}
}

function addListeners(clsdPane, data) {
	addEventHandler(clsdPane, 'click',function() {openPane(data)});
	addEventHandler(clsdPane, 'click',function() {closePanes(data)});
}	

function closePanes(data) {
	var updateAnchors = getId("tabContent").querySelectorAll("a.settingsAnchor");
	for (var i=0; i<updateAnchors.length; i++) {
		var updateAnchor = updateAnchors[i];
		var anchorClasses = updateAnchor.classList+'';
		
		if (anchorClasses.indexOf('hide') > -1 && 
			updateAnchor.id !== 'settingsAnchor_'+data.form.file) {
			//If anchor is hidden then pane is open, remove the open pane
			var fileExt = updateAnchor.id.split("_")[1];
			var li = getId("tabContent").querySelector('li#settingsLi_'+fileExt);
			var openPane = getId("tabContent").querySelector('div#openPane'+fileExt);

			updateAnchor.removeClass('hide');
			li.removeChild(openPane);
		}
	}
}
 
function openPane(data) {
	//Do not rely on event id due to delegation. 
	//Id returned may be of child id not the parent li
	var inputs = data.form.inputs;
	var title = data.title;
	var fileExt = data.form.file;
	var clsdPane = getNode('li#settingsLi_'+fileExt);
	var openPane;
	var cancelBtn;
	var listItem;
	var htmlStr = '';
	var inputsHtml = '';
	var i;
	

	for (i=0; i < inputs.length; i++) {
		var input = inputs[i];
		var dbRef = input.db;
		var enctype = input.enctype;

		inputsHtml += input.type !== 'radio' ? input.name+':<br>' : '';
		inputsHtml += '<input type="'+input.type+'" class="signup update" '+ ((input.type=='radio' && input.selected) ? 'checked' : '') +' autofocus= "'+ input.selected +'" id="'+ dbRef +'" name="'+ dbRef +'" value="'+ input.value +'" onchange="'+input.onchange+'()"/>';
		inputsHtml += input.type == 'radio' ? '<span class="radioLabel">'+input.name+'</span>' : '';
		inputsHtml += '<span class="settings formErr hide" id="formErr_'+ dbRef +'">';
		inputsHtml +=		'<i class="fas fa-times close" aria-hidden="true"></i>'+ input.errMsg;
		inputsHtml += '</span><br>';
		inputsHtml +=  input.onchange.length ? '<div id="onchangeInfo_'+ dbRef +'"></div>': '';
	}

	htmlStr +=	'<div id="openPane' + fileExt + '">';
	htmlStr +=		'<h4 class="pane" title="' + title + '">' + title  + '</h4>'
	htmlStr +=		'<form class="settingsForm" method="post" action="js/submitUpdates/update_' + fileExt + '.php" onsubmit="return validate_' + fileExt + '()" enctype="'+ enctype +'"> ';
	htmlStr +=			'<div class="settingsDisplay" title="' + title  + '">';
	htmlStr +=				inputsHtml;
	htmlStr +=				'<div class="settings disclaimer">' + data.form.disclaimer + '</div>';
	htmlStr +=				'<hr>';
	htmlStr +=				"link" in data.form ? 
								'<a href="'+data.form.link.href+'"><input type="button" value="'+data.form.link.text+'" name="" class="updatebtn"/></a>'
								:
								'<input type="submit" value="'+( data.form.btnName  || "Save Changes")+'" name="update_' + fileExt + '" class="updatebtn"/>';
	htmlStr +=				'<input type="button" value="Cancel" class="updatebtn" id="cancelBtn_' + fileExt + '"/>';
	htmlStr +=			'</div>';
	htmlStr +=		'</form>'; 
	htmlStr +=	'</div>';

	clsdPane.insertAdjacentHTML('beforeend',htmlStr);
	
	listItem = getNode('a#settingsAnchor_'+fileExt);
	listItem.classList.add('hide');

	openPane = getNode('div#openPane'+fileExt);
	cancelBtn = getNode('input#cancelBtn_'+fileExt);

	addEventHandler(cancelBtn, 'click', function(e) { 
		listItem.removeClass('hide'); 
		clsdPane.removeChild(openPane);
	});
}

function showFileInfo(e){
	var me = getActivatedObject(e);
	var infoDiv = getNode('div#onchangeInfo_picture');

	if ('files' in me){
		var file = me.files[0];
		var size = Math.round(file.size/1024);
		var txt = "";

		txt += '<span class="showInfo">Size: ' + size + ' KB</span>';
		txt +=  size > 32 ?'<span class="showInfoValid">*File does not meet upload requirements</span><br>':'<br>'; 
		txt += '<p class="showInfo">Type: ' + file.type+'</p>'; 
		infoDiv.innerHTML = txt;
	} else {
		alert('No file found')
		return;
	}

}
function validate_picture(){
	var picture = getNode('input#picture');
	var file = picture.files[0];
	var picture_Err = getNode('span#formErr_picture');
	var txt = "";
	var insertErr = function() {
		picture_Err.innerHTML = txt;
		picture_Err.removeClass('hide');
	}

	if ('files' in picture) {
		//Check if files array in file element
		if (picture.files.length !== 1) {
			//Check if exactly 1 file uploaded
		  txt = "One file to upload";
		  insertErr();
		  return false;
		} else { 
			if ('size' in file) { 
			  var size = Math.round(file.size/1024);

			  if (size > 32) {
				txt += " Size: " + size + " KB too large";
				insertErr();
				return false;
			  } 
			  if (size > 0 && size < 32) {
				picture_Err.classList.add('hide');
				var confirmUpdate = confirm('Are you sure you want to update your profile picture to:\n\n File Name: '+file.name +'\n File Size: '+size+' KB');
				return confirmUpdate ? true : false;
				} else {
					txt += " File invalid";
					insertErr();
					return false;
				}
			} else {return false}
		}
	} else {
		txt = "No file found";
		insertErr();
		return false;
	}
	
}

function validate_dob() {
	var inputDob =getNode('input#dob');
	var dob = inputDob.value.split('/');
    var month = dob[0];
    var day = dob[1];
    var year = dob[2];
	if (RegExp(/^\d{1,2}\/\d{1,2}\/\d{4}$/).test(inputDob.value)) {
		if (month < 1 ||
            month > 12 ||
            day < 1 ||
            day > 31 ||
            year < 1901 ||
            year > 2015 ||
            (month == 2 && day > 29) || //February
            (month == 4 || month == 6 || month == 9 || month == 11 && day > 30) //Months w/ 30 days
		){
			getNode('span#formErr_dob').removeClass('hide');
			inputDob.classList.add('red');
			return false;
		} else { 
			var confirmUpdate = confirm('Are you sure you want to update your birthdate to \''+inputDob.value+'\'?'); 
			if(confirmUpdate){return true;}
		}
	} else { 
		getNode('span#formErr_dob').removeClass('hide'); 
		inputDob.classList.add('red');
		return false; 
	}	
}

function validate_password(){
	var password1 = getNode('input#password1');
	var password2 = getNode('input#password2');
	var password3 = getNode('input#password3');
	var password1_Err = getNode('span#formErr_password1');
	var password2_Err = getNode('span#formErr_password2');
	var password3_Err = getNode('span#formErr_password3');
	var err = false;

	if (!RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/).test(password1.value)  || password1.value.length < 8) {
		//Passwords must include at least one capital letter, one special character, and one number
		password1_Err.removeClass('hide'); 
		password1.classList.add('red');
		err = true;
	} else {
		password1_Err.classList.add('hide'); 
		password1.removeClass('red');
	}

	if (!RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/).test(password2.value)  || password2.value.length < 8) {
		password2_Err.removeClass('hide'); 
		password2.classList.add('red');
		err = true;
	} else {
		password2_Err.classList.add('hide'); 
		password2.removeClass('red');
	}

	if (!RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/).test(password3.value)  || password2.value.length < 8) {
		password3_Err.removeClass('hide'); 
		password3.classList.add('red');
		err = true;
	} else {
		password3_Err.classList.add('hide'); 
		password3.removeClass('red');
	}

	if (err) {
		return false;
	} else {
		var confirmUpdate = confirm('Press "Ok" to be logged out and log back in with your new password. Press "Cancel" to return to the current page'); 
		if(confirmUpdate){
			alert('You will now be logged out.'); 
			return true;
		}
	}
}

function validate_name() {
	var firstname = getNode('input#first_name');
	var lastname = getNode('input#last_name');
	var firstname_Err = getNode('span#formErr_first_name');
	var lastname_Err = getNode('span#formErr_last_name');
	var err = false;

	if (RegExp(/[^-\'a-zA-Z]+/).test(firstname.value) || firstname.value < 1 ) {
		//Any character other than -,',or letters
		firstname_Err.removeClass('hide'); 
		firstname.classList.add('red');
		err = true;
	} else {
		firstname_Err.classList.add('hide'); 
		firstname.removeClass('red');
	}

	if (RegExp(/[^-\'a-zA-Z]+/).test(lastname.value) || lastname.value < 1 ) {
		//Any character other than -,', or letters
		lastname_Err.removeClass('hide'); 
		lastname.classList.add('red');
		err = true;
	} else {
		lastname_Err.classList.add('hide'); 
		lastname.removeClass('red');
	}

	if (!err) {
		var confirmUpdate = confirm('Are you sure you want to update your name to \''+ firstname.value +' '+ lastname.value +'\'?'); 
		if(confirmUpdate){
			alert('Your account has been successfully updated');
			return true;
		}
	} else {return false;}
}

function validate_gender(){
	var gender = getNode('input#gender');
	var genderVal= gender.value.toUpperCase();

	if (genderVal == "M" || genderVal == "F") {
		var confirmUpdate = confirm('Are you sure you want to update your gender to \''+ genderVal +'\'?'); 
		if (confirmUpdate) {
			alert('Your account has been successfully updated.');
			return true;
		} else {
			alert('Action aborted.'); 
			return false;}
	} else {
		getNode('span#formErr_gender').removeClass('hide'); 
		gender.classList.add('red');
		return false;
	}
}

function validate_email(){
	var email1 = getNode('input#email1');
	var email2 = getNode('input#email2');
	var email_Err1 = getNode('span#formErr_email1');
	var email_Err2 = getNode('span#formErr_email2');
	var passwordEm = getNode('input#passwordEm');
	var passwordEm_Err = getNode('span#formErr_passwordEm');
	var err = false;
	
	if (!RegExp(/\S{2,}@\S{2,}\.\S{2,}/).test(email1.value)) {
		//2+ non spaces, '@',2+ non spaces, '.', 2+ non spaces
		email_Err1.removeClass('hide'); 
		email1.classList.add('red');
		err = true;
	} else {
		email_Err1.classList.add('hide'); 
		email1.removeClass('red');
	}
	if (!RegExp(/\S{2,}@\S{2,}\.\S{2,}/).test(email2.value) || email1.value == email2.value) {
		//2+ non spaces, '@',2+ non spaces, '.', 2+ non spaces
		email_Err2.removeClass('hide'); 
		email2.classList.add('red');
		err = true;
	} else {
		email_Err2.classList.add('hide'); 
		email2.removeClass('red');
	}

	if (!RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_|\W])/).test(passwordEm.value)  ||
		passwordEm.value.length < 8) {
		//Passwords must be at least 8 characters long and 
		//include at least one capital letter, one special character, and one number
		passwordEm_Err.removeClass('hide'); 
		passwordEm.classList.add('red');
		err = true;
	} else {
		passwordEm_Err.classList.add('hide'); 
		passwordEm.removeClass('red');
	}

	if (err) {
		return false;
	}else {
		var confirmUpdate = confirm(
			'Are you sure you want to update your email to \''+ email2.value +'\'?\n\n'+
			'Press "Ok" to send verification and log out.\n'+
			'Press "Cancel" to return to the current page.'); 
		if (confirmUpdate) {
			alert('You will now be logged out.'); 
			return true;
		} else {
			return false;
		}
	} 
}

function validate_igDisplay() {
	var action = getNode('input[type="radio"][name="IG_Private"]:checked').value;
	var userResponse;
	if(action == 1) {
		userResponse = confirm('Are you sure you want to hide your Instagram feed fom other users?');
		return userResponse ? true : false;
	} else if (action == 0) {
		userResponse = confirm('Make your private Instagram feed viewable?');
		return userResponse ? true : false;
	} else {
		alert('No item selected.');
		return false;
	}

} 