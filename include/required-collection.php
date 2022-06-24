<?php error_reporting(E_ERROR | E_PARSE);
require($rootPath."include/db_makelink.php");
function begin(){global $con;$con->Execute("START TRANSACTION");}
function commit(){global $con;$con->Execute("COMMIT");}
function rollback(){global $con;$con->Execute("ROLLBACK");}
session_start();
$_SESSION["userid"]="bdefault";
?>