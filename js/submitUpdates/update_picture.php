<?php
  require_once('../../startsession.php');
  require_once('../../connectvars.php');

  
// Connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$formErr5 = '';

  if (isset($_POST['update_picture'])) {
    //If first or last name is updated
    $picture = $_FILES['picture'];
    $picture_name = mysqli_real_escape_string($dbc, trim($picture['name']));
    $picture_type = $picture['type'];
    $picture_size = $picture['size'];

    $dir = '../../'.BBB_UPLOADPATH .'/user_'. $_SESSION['user_id'];
    if (is_dir($dir) === false) {
        mkdir($dir);
    }
    $target = '../../'.BBB_UPLOADPATH .'/user_'. $_SESSION['user_id'] .'/'. $picture_name;

    function send_headers(){
        $home_url = 'https://' . $_SERVER['HTTP_HOST'] . '/editprofile.php?err='.$formErr5;
        header('Location: ' . $home_url, true, 303);
    }
    
    if (!empty($picture_name)) {
    	if ((($picture_type == 'image/gif') || ($picture_type == 'image/jpeg') || ($picture_type == 'image/pjpeg') || ($picture_type == 'image/png'))
        && ($picture_size > 0) && ($picture_size <= BBB_MAXFILESIZE)) {
            if ($picture['error'] == 0) {
                // Move the file to the target upload folder
                if (move_uploaded_file($picture['tmp_name'], $target)) {
                  $query = "UPDATE profile SET picture = '$picture_name'" .
                  "  WHERE user_id = '" . $_SESSION['user_id'] . "'";
                  
                  mysqli_query($dbc, $query)
                  or die("\nSQL_SELECT_ERR: " . mysqli_error($dbc) . "\nSQL_ERR_NO.: " . mysqli_errno($dbc) . "\nQUERY_USED: ". $query );
                  
                  mysqli_close($dbc);
                  send_headers();
                  exit();
                } else {
                    $formErr5= 'Sorry, there was a problem uploading your image.'; send_headers();
                }
            } else {
                $formErr5= 'Sorry, there was an error uploading your image. Try your upload again.'; send_headers();
            }
        } else {
            $formErr5= 'The image must be a GIF, JPEG, or PNG image file no greater than ' . (BBB_MAXFILESIZE / 1024) . ' KB in size.';
            send_headers();
        }
    }   
    @unlink($picture['tmp_name']);
    }
    else {
      echo '<p class="error">Sorry, you\'re picture cannot be uploaded at this time.</p>'; send_headers();
    }
?>
