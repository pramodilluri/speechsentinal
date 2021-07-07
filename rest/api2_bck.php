<?php
header("Content-Type:application/json");
if ($_GET['order_id']=="") {
	include('db.php');
	$order_id = $_GET['order_id'];
	$result = mysqli_query(
	$con,
	"SELECT * FROM `sentimentAnalysis` ORDER BY idAnalysis DESC");
	if(mysqli_num_rows($result)>0){
	$row = mysqli_fetch_array($result);
	$audioText = $row['audioText'];
	$sentimentResult = $row['sentimentResult'];
	$created_at = $row['created_at'];
	response($audioText, $sentimentResult, $created_at);
	mysqli_close($con);
	}else{
		response(NULL, NULL, 200,"No Records Found");
		}
}else{
	response(NULL, NULL, 400,"Invalid Request");
	}

function response($audioText,$sentimentResult,$created_at){
	$response['audioText'] = $audioText;
	$response['sentimentResult'] = $sentimentResult;
	$response['created_at'] = $created_at;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>