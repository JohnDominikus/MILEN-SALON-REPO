<?php
session_start();
include('includes/dbconnection.php');

$cid = $_GET['deleteid'];
$sql = "DELETE FROM tblcustomers WHERE ID = $cid ";
if ($con->query($sql)== true) {
    $msg ['success'] = "Record Deleted";
} else{
    $msg ['error'] = "No record delete";

}

header("location:customer-list.php");
exit();

?>
