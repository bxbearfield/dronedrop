<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['update_gender'])) {
    $gender = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['gender']))) ;
    $gender == 'M'? $gender = 1 : $gender = 2;

    if (!empty($gender) && ($gender === 1 || $gender === 2)) {
    	
        $query = "UPDATE profile SET gender = '$gender'" .
        "  WHERE user_id = '" . $_SESSION['user_id'] . "'";

        mysqli_query($dbc, $query)
        or die("\nSQL_SELECT_ERR: " . mysqli_error($dbc) . "\nSQL_ERR_NO.: " . mysqli_errno($dbc) . "\nQUERY_USED: ". $query );
        mysqli_close($dbc);

        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/bikinibottombuddies/editprofile.php';
        header('Location: ' . $home_url, true, 303);

        exit();
      } else {
        echo 'Invalid submission:'.$gender;
    }
  }
  mysqli_close($dbc);
?>