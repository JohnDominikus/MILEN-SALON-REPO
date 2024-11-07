<?php
session_start();
include('includes/dbconnection.php');
header("location:manage-services.php");

$cid = $_GET['deleteid'];
$sql = "DELETE FROM tblservices WHERE ID = $cid ";
if ($con->query($sql)== true) {
    $msg ['success'] = "Record Deleted";
} else{
    $msg ['error'] = "No record delete";

}

header("location:manage-services.php");
exit();



