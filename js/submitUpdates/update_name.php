<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  $formErr2 = '';
  $formErr3 = '';
  if (isset($_POST['update_name'])) {
    //If first or last name is updated
    $firstname = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $lastname = mysqli_real_escape_string($dbc, trim($_POST['last_name']));

    if (preg_match('/[^-\'a-zA-Z]+/', trim($_POST['first_name'])) === 1 || strlen($firstname) < 2 ) {
        $formErr2 = '*Invalid first name';
    }

    if (preg_match('/[^-\'a-zA-Z]+/', trim($_POST['last_name'])) === 1 || strlen($lastname) < 2 ) {
        $formErr3 = '*Invalid last name';
    } 
    if (!$formErr2 && !$formErr3 &&
      !empty($firstname) && 
      !empty($lastname) ) {
    	
        $query = "UPDATE profile SET first_name = '$firstname', last_name = '$lastname'" .
        "  WHERE user_id = '" . $_SESSION['user_id'] . "'";

        mysqli_query($dbc, $query)
        or die("\nSQL_SELECT_ERR: " . mysqli_error($dbc) . "\nSQL_ERR_NO.: " . mysqli_errno($dbc) . "\nQUERY_USED: ". $query );
        mysqli_close($dbc);

        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/bikinibottombuddies/editprofile.php';
        header('Location: ' . $home_url, true, 303);

        exit();
    } else {echo "Invalid submission.\n".$formErr2. "\n" .$formErr3;}
  }
  mysqli_close($dbc);
?>