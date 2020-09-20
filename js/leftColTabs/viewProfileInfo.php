<?php
  // Start the session
  require_once('../../startsession.php');
  require_once('../../connectvars.php');
  
  // Insert the page header
  //$page_title = 'My Profile';
  $style_sheet = 'viewprofile.css';
 
  
  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Grab the profile data from the database
  if (!isset($_GET['id'])) {
    $query = "SELECT first_name, last_name, email, picture, address, city, state, zip_code, country, lat, lon" . 
        " FROM profile WHERE user_id = '" . $_SESSION['user_id'] . "'";
  }
  else {
    $query = "SELECT first_name, last_name, picture, address, city, state, zip_code, country, lat, lon" . 
        " FROM profile WHERE user_id = '" . $_GET['id'] . "'";
  }
  $data = mysqli_query($dbc, $query)				
  or die(' SQL_SELECT_ERR: ' . mysqli_error($dbc) . ' SQL_ERR_NO.: ' . mysqli_errno($dbc) . ' QUERY_USED: '. $query );
  
  if (mysqli_num_rows($data) == 1) {
    //The user row was found so display the user data
     $row = mysqli_fetch_array($data);
    
     $items='[
      {
        "title" : "Picture",
        "value" : "'.($row['picture'] ? $row['picture'] : 'Click to add photo').'",
        "form" : {
          "file" : "picture",
          "disclaimer" : "The image must be a GIF, JPEG, or PNG image file no greater than ' . (BBB_MAXFILESIZE / 1024) . ' KB in size.",
          "inputs" : [
            {"name": "Picture", "db" : "picture", "type":"file", "selected":"false", "value":"'.$row['picture'].'", "errMsg":"", "enctype":"multipart/form-data", "onchange":"showFileInfo"}
          ] 
        }
      },
      {
        "title" : "Name",
        "value" : "'.$row['first_name'].' '.$row['last_name'].'",
        "form" : {
          "file" : "name",
          "disclaimer" : "Name changes are only permitted once every 60 days",
          "inputs" : [
            {"name": "First Name", "db" : "first_name", "type":"text","selected":"false", "value":"'.$row['first_name'].'", "errMsg":"Please enter a valid first name", "enctype":"", "onchange":""},
            {"name": "Last Name", "db" : "last_name", "type":"text", "selected":"false", "value":"'.$row['last_name'].'", "errMsg":"Please enter a valid last name", "enctype":"", "onchange":""}
          ] 
        }
      },
      {
        "title" : "Username",
        "value" : "'.$row['email'].'",
        "form" : {
          "disclaimer" : "To update your e-mail requires reverification and signing back in. E-mail will not be changed until verified",
          "file" : "email",
          "inputs" : [
            {"name": "Current E-mail", "db" : "email1", "type":"text", "selected":"false", "value":"'.$row['email'].'", "errMsg":"Please enter a valid e-mail address", "enctype":"", "onchange":""},
            {"name": "New E-mail", "db" : "email2", "type":"text", "selected":"false", "value":"", "errMsg":"Please enter a valid e-mail address", "enctype":"", "onchange":""},
            {"name": "Enter Password", "db" : "passwordEm", "type":"password", "selected":"false", "value":"", "errMsg":"Invalid entry", "enctype":"", "onchange":""}
          ]
        }
      },
      {
        "title" : "Address",
        "value" : "'.$row['address'].'",
        "form" : {
          "disclaimer" : "Please use standard date format for each entry.",
          "file" : "address",
          "inputs" : [
            {"name": "Street", "db" : "email1", "type":"text", "selected":"false", "value":"'.$row['address'].'", "errMsg":"Please enter a valid  address", "enctype":"", "onchange":""},
            {"name": "City", "db" : "email2", "type":"text", "selected":"false", "value":"'.$row['city'].'", "errMsg":"Please enter a valid city", "enctype":"", "onchange":""},
            {"name": "State", "db" : "passwordEm", "type":"text", "selected":"false", "value":"'.$row['state'].'", "errMsg":"Invalid entry", "enctype":"", "onchange":""},
            {"name": "Zip Code", "db" : "email2", "type":"text", "selected":"false", "value":"'.$row['zip_code'].'", "errMsg":"Please enter a valid zip code", "enctype":"", "onchange":""}
          ]
        }
      }
    ]';
    mysqli_close($dbc);
    exit($items);
    }
?>

