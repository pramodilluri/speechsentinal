<?php
header("Content-Type:application/json");
if ($_GET['order_id']=="") {
	include('db.php');
	$order_id = $_GET['order_id'];
	$result = mysqli_query(
	$con,
	"SELECT * FROM `sentimentAnalysis` ORDER BY idAnalysis DESC");
	if(mysqli_num_rows($result)>0) {
	
    $row = mysqli_fetch_array($result);
	$audioText = $row['audioText'];
	$sentimentResult = $row['sentimentResult'];
	$created_at = $row['created_at'];
	
    $analysis_arr = array();
    $analysis_arr["records"] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $analysis_item = array(
            "audioText" = $audioText,
            "sentimentResult" = $sentimentResult,
            "created_at" = $created_at
        );

        array_push($analysis_arr["records"], $analysis_item);
    }
    
    response($analysis_arr, 200, "Records found");
	mysqli_close($con);
	
    } else {
		response(NULL, 200,"No Records Found");
		}
}else{
	response(NULL, 400,"Invalid Request");
	}

function response($response,$response_code,$response_desc) {
	$json_response = json_encode($response);
	echo $json_response;
}
?>