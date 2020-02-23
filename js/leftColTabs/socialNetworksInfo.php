<?php
// Start the session
require_once('../../startsession.php');
require_once('../../connectvars.php');


//Connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Grab the profile data from the database
$query = "SELECT IG_Private" . 
    " FROM profile WHERE user_id = '" . $_SESSION['user_id'] . "'";

$data = mysqli_query($dbc, $query)				
or die(' SQL_SELECT_ERR: ' . mysqli_error($dbc) . ' SQL_ERR_NO.: ' . mysqli_errno($dbc) . ' QUERY_USED: '. $query );

if (mysqli_num_rows($data) == 1) {
  //The user row was found so display the user data
   $row = mysqli_fetch_array($data);
   $private = $row['IG_Private'];
}

$activateUrl = isset($_SESSION['igActivateUrl']) ? $_SESSION['igActivateUrl'] : '';
if ( isset($_SESSION['igUser']) ) : 
    $user = $_SESSION['igUser']; 
    
    $items='[
        {
          "title" : "Instagram",
          "value" : "Username: '.$user['username'].'",
          "form" : {
            "file" : "igDisplay",
            "disclaimer" : "Instagram content has been authorized for the following: \nMember: '.$user['username'].', \nAccount type: '.$user['account_type'].', \nMedia count: '.$user['media_count'].'. \nTo hide your IG feed, select \'Hide\' and click on the button below.  ",
            "inputs" : [
              {"name": "Show", "db" : "IG_Private", "type":"radio","selected":"'.($private ? false : true).'", "value":"0", "errMsg":"Please select an option", "enctype":"", "onchange":""},
              {"name": "Hide", "db" : "IG_Private", "type":"radio", "selected":"'.($private ? true : false).'", "value":"1", "errMsg":"Please select an option", "enctype":"", "onchange":""}
            ],
            "btnName" : "Change IG Display"
          }
        }
    ]';
       else : $items='[
  {
    "title" : "Instagram",
    "value" : "Not set",
    "form" : {
      "file" : "igDisplay",
      "disclaimer" : "Click the \"Add Instagram Feed\" button to authorize BBB to import your instagram photos.",
      "inputs" : [],
      "link" : {
          "href":"'.$activateUrl.'",
          "text":"Add Instagram Feed"
      }
    }
  }
]'; endif;
  
exit($items);
?>