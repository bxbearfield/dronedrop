<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['update_igDisplay'])) {
    $igPrivate = mysqli_real_escape_string($dbc, trim($_POST['IG_Private']));
    if ($igPrivate == 0 || $igPrivate == 1) {
    	
        $query = "UPDATE profile SET IG_Private = '$igPrivate' WHERE user_id = '" . $_SESSION['user_id'] . "'";

        mysqli_query($dbc, $query)
        or die("\nSQL_SELECT_ERR: " . mysqli_error($dbc) . "\nSQL_ERR_NO.: " . mysqli_errno($dbc) . "\nQUERY_USED: ". $query );
        mysqli_close($dbc);

        $url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php';
        header('Location: ' . $url, true, 303);

        mysqli_close($dbc);
        exit();
    } else {echo "Invalid submission.";}
  }
?>
