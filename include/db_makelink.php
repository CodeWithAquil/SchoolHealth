<?php  
#This line loads those variables
require($rootPath.'include/config.php');
#Default to msql if dbtype is missing
$dbtype='mysql';
#Establish a database link	
$dblink_ok=0;
#ADODB connection
require($rootPath.'include/adodb/adodb.inc.php');
$user = DBUSER;
$pass = DBPWD;
$dbName = DBNAME;
$dbHost = DBHOST;
$con=ADONewConnection($dbtype);
$dblink_ok=$con->Connect($dbHost,$user,$pass,$dbName);
?>
