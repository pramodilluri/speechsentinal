<?php
header("Content-Type:application/json");
if ($_GET['order_id']=="") {
	
	include('db.php');

	$result = mysqli_query($con,"SELECT * FROM sentimentAnalysis ORDER BY idAnalysis DESC");
	
	if(mysqli_num_rows($result)>0) {    
       $analysis_arr = array();
       while ($row = mysqli_fetch_array($result)) {
			extract($row);
            //$analysis_arr["$audioText"] = $sentimentResult;
			$analysis_item = array(
                "audioText" => $audioText,
                "sentimentResult" => $sentimentResult,
                "created_at" => $created_at
            );
			array_push($analysis_arr, $analysis_item);
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