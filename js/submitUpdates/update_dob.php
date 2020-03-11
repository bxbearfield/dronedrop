<?php
  require_once('./../../startsession.php');
  require_once('./../../connectvars.php');

  //Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  
  if (isset($_POST['update_dob'])) {
    //Update birthdate
    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', trim($_POST['dob'])) == 1) {
        $dob = explode('/',mysqli_real_escape_string($dbc, trim($_POST['dob'])));
        $month = $dob[0];
        $day = $dob[1];
        $year = $dob[2];
        if(
            $month < 1 ||
            $month > 12 ||
            $day < 1 ||
            $day > 31 ||
            $year < 1901 ||
            $year > 2015 ||
            ($month == 2 && $day > 29) || //February
            ($month == 4 || $month == 6 || $month == 9 || $month == 11 && $day > 30) //Months w/ 30 days
        ){
            return $formErr6 = 'Invalid date submitted';
        } 
        else {
            $query = "UPDATE profile SET month = '$month', day = '$day', year = '$year' " .
            "  WHERE user_id = '" . $_SESSION['user_id'] . "'";

            mysqli_query($dbc, $query)
            or die("\nSQL_SELECT_ERR: " . mysqli_error($dbc) . "\nSQL_ERR_NO.: " . mysqli_errno($dbc) . "\nQUERY_USED: ". $query );
            
            mysqli_close($dbc);

            $home_url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php';
            header('Location: ' . $home_url, true, 303);
            $formErr6 = '';
            
            exit();
        }
    } else {echo 'Invalid submission.';}
  }
  mysqli_close($dbc);
?>
