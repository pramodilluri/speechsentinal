<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$dbserverip = "localhost"; //local DB
//$dbserverip = "185.201.11.149";  //remote DB
define('DB_SERVER', $dbserverip);
define('DB_USERNAME', 'u754228801_jrsalaza');
define('DB_PASSWORD', 'Njsm_9161');
define('DB_NAME', 'u754228801_assignments');


/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//else {
  //  echo ("Connected successfully! - <a href='fetchmylists.php'>Proto Home</a>");
//}
?>