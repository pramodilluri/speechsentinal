<!DOCTYPE html>

<?php

    // Include config file
    require_once "db_conn.php";

    // Include common functions file
    require_once "commonf.php";

   // echo "<hr>";
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
       // Check input errors before calling the API
        $upload_err = "";
        if(empty($upload_err)) {
            
            $target_dir = "";
            $uploadOk = 1;
            
            if ($uploadOk==1) {
                
                $text_to_analyze = $_POST["text_to_analyze"];
                
                //Call the Azure Sentiment Analysis API
                //echo "<b>Text to analyze: " . $text_to_analyze . "</b><br>";
				
                
                $googlespeechURL = "https://som-nlp-speech-sentiment-edu.azurewebsites.net/analyze";

                $data = array(
                    "id" => "1",
                    "language" => "en",
                    "text" => $text_to_analyze
                );
                
                $data_string = json_encode($data);                                                              
                
                $ch = curl_init($googlespeechURL);                                                                      
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                         
                    'Content-Type: application/json',                                                               
                    'Content-Length: ' . strlen($data_string))                                                          
                );                      
                
                $result = curl_exec($ch);
                $result_array = json_decode($result, true);
				$sentimentResult = $result_array["rootElement"]["documents"][0]["sentiment"];
				insertAnalysisLog($text_to_analyze,$sentimentResult,$link);
				/*echo "<b>JSON outcome: </b><br>". $result . "<br>";
                
                
                //echo "Sentiment: " . $result_array["rootElement"][0]["documents"][0] . "<br>";
                $result_sentiment = $result_array["rootElement"]["documents"][0];
                foreach($result_sentiment as $keyS=>$valueS){
                    echo $keyS . " (S) =>" . $valueS . "<br>";                
                }
                echo "Version: " . $result_array["rootElement"]["modelVersion"] . "<br>";
                echo "<b>Sentiment: " . $result_array["rootElement"]["documents"][0]["sentiment"] . "</b><br>";
                
                $result_sentiment_scores = $result_array["rootElement"]["documents"][0]["confidenceScores"];
                foreach($result_sentiment_scores as $keyS=>$valueS){
                    echo $keyS . " (SSc) =>" . $valueS . "<br>";                
                }
                echo "<b>Positive Score: " . $result_array["rootElement"]["documents"][0]["confidenceScores"]["positive"] . "</b><br>";
                echo "<b>Neutral Score: " . $result_array["rootElement"]["documents"][0]["confidenceScores"]["neutral"] . "</b><br>";
                echo "<b>Negative Score: " . $result_array["rootElement"]["documents"][0]["confidenceScores"]["negative"] . "</b><br>";
                echo "...end of sentiment traverse...<br>";
                
                echo "<b>Traverse the JSON outcome: </b><br>";
                foreach($result_array as $key=>$value){
                    echo $key . " (0) =>" . $value . "<br>";
                    $result_subarray = $value;
                    foreach($result_subarray as $key2=>$value2){
                        echo $key2 . " (1) =>" . $value2 . "<br>";
                        
                        $result_subarray2 = $value2;
                        foreach($result_subarray2 as $key3=>$value3){
                            echo $key3 . " (2) =>" . $value3 . "<br>";
                            
                            $result_subarray3 = $value3;
                            foreach($result_subarray3 as $key4=>$value4){
                                echo $key4 . " (3) =>" . $value4 . "<br>";
                                
                               $result_subarray4 = $value4;
                               foreach($result_subarray4 as $key5=>$value5){
                                    echo $key5 . " (4) =>" . $value5 . "<br>"; 
                                
                               }
                                
                            }
                            
                        }
                    } 
                }
                echo "<br>";
            
               echo "Ok!";

               //insert into database
               echo "<br><b>Insert analysis into the database...</b><br>";
               insertAnalysisLog($text_to_analyze,$sentimentResult,$link);

               //retrieve the latest analysis from DB
                echo "<br><b>Retrieve the latest analysis from the database...</b><br>";
                $url = "http://nlpcloudpipeline.azurewebsites.net/rest/api2";
                
                $client = curl_init($url);
                curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
                $response = curl_exec($client);
                
                $result = json_decode($response);
                
                echo "<table>";
                echo "<tr><td>Audio text:</td><td>$result->audioText</td></tr>";
                echo "<tr><td>Sentiment Result:</td><td>$result->sentimentResult</td></tr>";
                echo "<tr><td>Created At:</td><td>$result->created_at</td></tr>";
                echo "</table>"; */
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Speech Sentiment Analyzer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
			height: 400px;
		}
		hr {
			display:none;
		}
		
		.sentiment {
			display: inline-block;
			padding: 5px 20px;
			border-radius: 3px;
			text-transform: capitalize;
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
	</style>
</head>
<body style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; font-size:13px;">
  <!-- <uidiv> -->
	<header class="text-center p-3">
		<h1 style="font-size: 24px;" class="">Speech Sentiment Analyzer</h1>
	</header>
	<?php 
		$status = '';
		if($result_array["rootElement"]["documents"][0]["sentiment"] == 'positive') {
			$status = 'success';
		} else if($result_array["rootElement"]["documents"][0]["sentiment"] == 'neutral') {
			$status = 'neutral';
		} else {
			$status = 'error';
		}
	?>
  <div id="content"  class="container">
	<div class="col-md-12  mt-5">
		<div id="textAnalyze mb-3" class="text-center" ><div class="sentiment <?php echo $status; ?>"><?php echo $result_array["rootElement"]["documents"][0]["sentiment"]; ?></div></div>
		<div id="response" class="form-control mt-3" style="height: 200px; border: 1px solid #ccc" placeholder="Result"><b><?php echo $text_to_analyze; ?></b></div>
		<!-- <textarea id="text_to_analyze" style="display: inline-block;width:500px;height:200px" name="text_to_analyze"></textarea> -->
		<div class="float-right p-3" style="text-align: right">
			<a id="viewFeedbackHistory" class="btn btn-primary mb-3" href="sentimentAnalyzer_db.php" target="_blank"><i class="fa fa-analyze"></i> View feedback history</a>
			<br>
			<a id="tryAgain" href="index.html" class="btn btn-primary" name="submit"><i class="fa fa-analyze"></i> Try again</a>
		</div>
        
	</div>
  </div>
    
</body>
</html>
