<!DOCTYPE html>

<?php

    // Include config file
    require_once "db_conn.php";

    // Include common functions file
    require_once "commonf.php";

    echo "<hr>";
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
                echo "<b>Text to analyze: " . $text_to_analyze . "</b><br>";
                
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
                echo "<b>JSON outcome: </b><br>". $result . "<br>";
                
                $result_array = json_decode($result, true);
                //echo "Sentiment: " . $result_array["rootElement"][0]["documents"][0] . "<br>";
                $result_sentiment = $result_array["rootElement"]["documents"][0];
                foreach($result_sentiment as $keyS=>$valueS){
                    echo $keyS . " (S) =>" . $valueS . "<br>";                
                }
                echo "Version: " . $result_array["rootElement"]["modelVersion"] . "<br>";
                echo "<b>Sentiment: " . $result_array["rootElement"]["documents"][0]["sentiment"] . "</b><br>";
                $sentimentResult = $result_array["rootElement"]["documents"][0]["sentiment"];
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
                echo "response 2: <br>" . $response . "<br>";
                
                $result = json_decode($response);
                echo "<b>Analysis Results Total So Far:</b> " . sizeof($result)."<br>";
                echo "<b>Sentiment Analysis Records coming from the Database:</b> <br>";
                for ($i=0, $len=sizeof($result); $i<$len; $i++) { 
                    $result_sentiment_scores = $result[$i];
                    foreach($result_sentiment_scores as $keyS=>$valueS){
                        echo "<b>" . $keyS . "</b> => " . $valueS . "<br>";                
                    }
                    echo "------------<br>";
                }

                //echo "<table>";
                //echo "<tr><td>Audio text:</td><td>$result->audioText</td></tr>";
                //echo "<tr><td>Sentiment Result:</td><td>$result->sentimentResult</td></tr>";
                //echo "<tr><td>Created At:</td><td>$result->created_at</td></tr>";
                //echo "</table>";
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sentiment Analyzer Using Azure API</title>
    
</head>
<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="css/main.css" rel="stylesheet">

    <div class="container h-100">
        <table>
       
        <tr>
            
            <td valign="top" style="width:500px">
                <h2>Sentiment Analysis Using Azure API version 2</h2>
               
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data"><?php echo $_POST["text_to_analyze"]; ?>
                    
				    Text to Analyze: <input type="text" name="text_to_analyze" id="text_to_analyze" value="<?php echo $_POST["text_to_analyze"]; ?>">
				    <br>
				    Sentiment Analysis API URL: <input type="text" name="sentanalysisapi_url" id="sentanalysisapi_url" value="https://som-nlp-speech-sentiment-edu.azurewebsites.net/analyze">
				    <br>
				    <button type="submit" class="btn btn-primary btn-block" name="submit"> Analyze Sentiment</button>
                 
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <a href="index4.html">Go back to Audio Intepretation</a>
            </td>
        </tr>    
        </table>
    </div> 
    
    
</body>
</html>