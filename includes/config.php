<?php
define('DB_SERVER','localhost');
define('DB_USER','erprotal_admin');
define('DB_PASS' ,'Muniray2014');
define('DB_NAME', 'erprotal_3acosystem');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
mysqli_set_charset($con,"utf8");
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>