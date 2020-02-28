<?php
require_once('startsession.php');
// Insert the page header
$page_title = ' View Profile';
require_once('head.php');

require_once('./connectvars.php');
$navClass = '';

// This is necessary when index.php is not in the root folder, but in some subfolder...
// Compare $requestURL and $scriptName to remove the repeat path values
$requestURI = explode('/', $_SERVER['REQUEST_URI']);
$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

for ($i= 0; $i < sizeof($scriptName); $i++) {
    if ($requestURI[$i] == $scriptName[$i]) {
        unset($requestURI[$i]);
    }
}

$command = array_values($requestURI);
$command = explode('.', $command[0]);
$first_name = isset($command[0]) ? mysqli_real_escape_string($command[0]) : '';
$last_name =isset($command[1]) ? mysqli_real_escape_string($command[1]) : '';
$user_id =isset($command[2]) ? mysqli_real_escape_string($command[2]) : '';

if ($first_name && $last_name && $user_id){
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SELECT IG_AccessToken, IG_Private, user_id, picture FROM profile WHERE " . 
            "first_name = '" . mysqli_real_escape_string($dbc, trim($first_name)) . "' AND last_name= '" . $last_name . "' AND user_id = '" . $user_id . "'";

    $data = mysqli_query($dbc, $query)				
    or die(' SQL_SELECT_ERR: ' . mysqli_error($dbc) . ' SQL_ERR_NO.: ' . mysqli_errno($dbc) . ' QUERY_USED: '. $query );
            
    if (mysqli_num_rows($data) == 1) {
        //The user row was found so display the user data
        $row = mysqli_fetch_array($data);
        if(!$row['IG_Private']){
            $showIgFeed = '';
            $viewUser = $row['user_id'];
            $viewPic = $row['picture'];
            require_once('./igBasicAPI.php');
            $params = array(
                'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
                'access_token' => $row['IG_AccessToken']
            );
            $ig = new instagram_basic_display_api( $params );
            
            if ($ig->getMedia()['data']){
                foreach ($ig->getMedia()['data'] as $post) { 
                    // Display the score data
                    $showIgFeed .= 	'<img class="igImage" src="'.$post['media_url'].'" />';
                }
            }
        }
    }
}
?>

<body>
    <div style="background-image: url('images/uploads/user_<?php isset($viewUser) ? $viewUser : '' ?>/<?php isset($viewPic) ? $viewPic :'' ?>');" class="content viewProfile">
        <?php include_once('navigation.php'); ?>
        <div  id="localContent viewProfile">
        <section class="instagram"><article id="viewIG"><p><?php isset($command[0]) ? $command[0].'\'s'  : '' ?> Instagram</p><?php isset($showIgFeed) ? $showIgFeed :''?></article></section>';
    </div>
    <script src="js/nav.js"></script> 
</body>
</html>