<?php
    // Start the session
    require_once('../../startsession.php');
    require_once('../../connectvars.php');
   
    
    //Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  
    // Grab the profile data from the database
    $query = "SELECT temp_pwd, password" . 
        " FROM profile WHERE user_id = '" . $_SESSION['user_id'] . "'";

    $data = mysqli_query($dbc, $query)				
    or die(' SQL_SELECT_ERR: ' . mysqli_error($dbc) . ' SQL_ERR_NO.: ' . mysqli_errno($dbc) . ' QUERY_USED: '. $query );
    
    if (mysqli_num_rows($data) == 1) {
      //The user row was found so display the user data
       $row = mysqli_fetch_array($data);
      
       $items='[
        {
          "title" : "Password",
          "value" : "*******",
          "form" : {
            "file" : "password",
            "disclaimer" : "Passwords must be at least 8 characters in length and contain at least one number, one special character, and one uppercase letter. You will be required to log in",
            "inputs" : [
              {"name": "Enter Password", "db" : "password1", "type":"password", "selected":"true", "value":"'.(SHA1($row['temp_pwd']) === $row['password']? $row['temp_pwd'] : '').'", "errMsg":"Invalid entry", "enctype":"", "onchange":""},
              {"name": "New Password", "db" : "password2", "type":"password", "selected":"false", "value":"", "errMsg":"Entry does not meet password requirements", "enctype":"", "onchange":""},
              {"name": "Confirm New Password", "db" : "password3", "type":"password", "selected":"false", "value":"", "errMsg":"Entries do not match/Invalid entry", "enctype":"", "onchange":""}
            ]
          }
        }
      ]';
    }
mysqli_close($dbc);
exit($items);
?>