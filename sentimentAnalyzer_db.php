<!DOCTYPE html>

<?php

    // Include config file
    require_once "db_conn.php";

    // Include common functions file
    require_once "commonf.php";
	
	$url = "http://nlpcloudpipeline.azurewebsites.net/rest/api2";
               
	$client = curl_init($url);
	curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
	$response = curl_exec($client);
   // echo "response 2: <br>" . $response . "<br>";
	
	$result = json_decode($response);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Speech Sentiment Analyzer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" >
    <style>
		header {
			background-color: #dfe5ec;
			color: #0044a9;
		}
		#content {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			margin: auto;
            height: 455px;
		}
		.btn {
		  border: 2px solid gray;
		  color: gray;
		  background-color: white;
		  padding: 8px 20px;
		  border-radius: 8px;
		  font-size: 20px;
		  font-weight: bold;
		}

		.upload-btn-wrapper input[type=file] {
		  font-size: 100px;
		  position: absolute;
		  left: 0;
		  top: 0;
		  opacity: 0;
		}
		.sentiment {
			display: inline-block;
			padding: 0 5px;
			border-radius: 3px;
			text-transform: capitalize;
			font-size: 12px;
			min-width: 80px;
			text-align:center;
		}
		.sentiment.success {
			border: 1px solid #06900b;
			color: #fff;
			background-color: #06900b;
		}
		.sentiment.neutral {
			border: 1px solid #ff9800;
			color: #fff;
			background-color: #ff9800;
		}
		.sentiment.error {
			border: 1px solid #f44336;
			color: #fff;
			background-color: #f44336;
		}
	</style>
</head>
<body>
   
	<header class="text-center p-3">
		<h1 style="font-size: 24px;" class="">Speech Sentiment Analyzer</h1>
	</header>
    <div id="content"  class="container">
       <table class="table" id="result" class="table table-striped " style="width:100%">
		<thead>
			<tr>
				<th>Audio Text</th>
				<th>Sentiment</th>
				<th>Created at</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0; $i< count($result); $i++) { ?>
			<?php 
				$status = '';
				if($result[$i]->sentimentResult == 'positive') {
					$status = 'success';
				} else if($result[$i]->sentimentResult == 'neutral') {
					$status = 'neutral';
				} else {
					$status = 'error';
				}
			?>
			<tr>
				<td><?php echo $result[$i]->audioText; ?></td>
				<td><span class="sentiment <?php echo $status ?>"><?php echo $result[$i]->sentimentResult; ?></span></td>
				<td><?php echo $result[$i]->created_at; ?></td>
			</tr>				
			<?php } ?>
		</tbody>
	   </table>
    </div>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#result').DataTable();
	} );
	</script>    
</body>
</html>
