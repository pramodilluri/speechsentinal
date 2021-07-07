<!DOCTYPE html>

<?php

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
                echo "<b>Text to analyze: <br>";
		echo "</b>" . $text_to_analyze . "<br>";
                
                $googlespeechURL = "https://sentimentanalysisappcmu.azurewebsites.net/analyze";

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
                echo "<br>";
                echo "Sentiment of the text : " . "<b>" . strtoupper($result_array["rootElement"]["documents"][0]["sentiment"]) . "<br>";
                echo "<br>";

                echo "<b>Response from sentiment analysis API : <br>";
                header('Content-Type: application/json');
		echo "<pre>";
		echo json_encode($result_array, JSON_PRETTY_PRINT);
		echo "</pre>";

	        echo "<br> <br>"; 
                
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sentiment analysis</title>
    
</head>
<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="css/main.css" rel="stylesheet">

    <div class="container h-100">
        <table>
       
        <tr>
            
            <td valign="top" style="width:500px">
                <h2>Sentiment Analysis Using Azure</h2>
               
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    
				    Text: <input type="text" name="text_to_analyze" id="text_to_analyze">
				    <br>
				    Sentiment Analysis API URL: <input type="text" name="sentanalysisapi_url" id="sentanalysisapi_url" value="https://sentimentanalysisappcmu.azurewebsites.net/analyze">
				    <br>
				    <button type="submit" class="btn btn-primary btn-block" name="submit"> Analyze Sentiment</button>
                 
                </form>
            </td>
        </tr>
        </table>
    </div> 
    
    
</body>
</html>
