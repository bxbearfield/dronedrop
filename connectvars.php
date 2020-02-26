<?php
//Define instagram API constants
define( 'IG_APP_ID', '466000760950745' );
define( 'IG_APP_SECRET', 'bf3ebdf3ee25a141621126e897151061' );
define( 'IG_APP_REDIRECT_URI', 'https://localhost/bikinibottombuddies/editprofile.php' );

//Define database connection constants
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'bikinibottombuddies');
// define('DB_USER', 'root');
// define('DB_PASSWORD', 'pwd');
//mysql://bd5b0b761c4a16:e65ab998@us-cdbr-iron-east-04.cleardb.net/heroku_0814bc8535b6a0c?reconnect=true
define('DB_HOST', 'us-cdbr-iron-east-04.cleardb.net');
define('DB_NAME', 'heroku_0814bc8535b6a0c');
define('DB_USER', 'bd5b0b761c4a16');
define('DB_PASSWORD', 'e65ab998');


// Define image application constants
define('BBB_UPLOADPATH', 'images/uploads/');
define('BBB_MAXFILESIZE', 32768);      // 32 KB
define('BBB_MAXIMGWIDTH', 120);        // 120 pixels
define('BBB_MAXIMGHEIGHT', 120);       // 120 pixels
?>