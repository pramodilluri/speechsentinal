<!DOCTYPE html>

<?php

    echo "<hr>";
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
       // Check input errors before calling the API
        $upload_err = "";
        if(empty($upload_err)) {
            
            $target_dir = "";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            echo "Image File Name = " .  $target_file . "<br>";
            echo "Image File Type = " .  $imageFileType . "<br>";
            
            // Allow certain file formats
            if($imageFileType != "wav" && $imageFileType != "m4a") {
              echo "Sorry, only WAV files are allowed.";
              $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
              echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
            
            if ($uploadOk==1) {
                echo "The audio file was SUCCESSFULLY uploaded...<Br>";
                
                //$file2interpret = "uploads/".htmlspecialchars(basename( $_FILES["fileToUpload"]["name"]));
                $file2interpret = htmlspecialchars(basename( $_FILES["fileToUpload"]["name"]));
                $app_server = $_POST["app_server"];
                $num_channels = $_POST["num_channels"];
                
                //Call the GCP SpeechToText API
                echo "APP server: " . $app_server . "<br>";
                echo "<b>File to interpret: " . $file2interpret . "</b><br>";
                echo "<b># Channels: " . $num_channels . "</b><br>";
                
                $googlespeechURL = "https://speech.googleapis.com/v1p1beta1/speech:recognize?key=AIzaSyDxhGZZpY4RI3xYr28fpWeyzgpDduo3wFo";
                $filedata = file_get_contents($app_server . $file2interpret);
                
                $data = array(
                    "config" => array(
                        "encoding" => "LINEAR16",
                        //"sample_rate_hertz" => 44100,
                        "language_code" => "en-US",
                        "audio_channel_count" => $num_channels
                    ),
                   "audio" => array(
                        "content" => base64_encode($filedata)
                    )
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
                echo $result . "<br>";
                $result_array = json_decode($result, true);
                
                echo "Transcript: " . $result_array["results"][0]["alternatives"][0]["transcript"] . "<br>";
                echo "Confidence: " . $result_array["results"][0]["alternatives"][0]["confidence"] . "<br>";
                foreach($result_array as $key=>$value){
                    echo $key . "=>" . $value . "<br>";
                    $result_subarray = $value;
                    foreach($result_subarray as $key2=>$value2){
                        echo $key2 . "=>" . $value2 . "<br>";
                        
                        $result_subarray2 = $value2;
                        foreach($result_subarray2 as $key3=>$value3){
                            echo $key3 . "=>" . $value3 . "<br>";
                            
                            $result_subarray3 = $value3;
                            foreach($result_subarray3 as $key4=>$value4){
                                echo $key4 . "=>" . $value4 . "<br>";
                                
                               $result_subarray4 = $value4;
                               foreach($result_subarray4 as $key5=>$value5){
                                    echo $key5 . "=>" . $value5 . "<br>"; 
                                
                               }
                                
                            }
                            
                        }
                    } 
                }
            
            
                // Decode JSON data to PHP object
                $obj = json_decode($result);
                // Loop through the object
                foreach($obj as $key=>$value){
                    echo $key . "==>" . $value . "<br>";
                }
            
                $text2search = trim($result_array["results"][0]["alternatives"][0]["transcript"]);
                echo "<b>Text interpreted from Audio: " . $text2search . "</b><br>";
                echo "Ok!";
                
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audio File Interpreter using GCP API</title>
    
</head>
<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="css/main.css" rel="stylesheet">

    <div class="container h-100">
        <table>
       
        <tr>
            
            <td valign="top" style="width:500px">
                <h2>Audio File Interpreter Using GCP</h2>
               
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    
                    Upload an audio file please!
				    <input type="file" name="fileToUpload" id="fileToUpload">
				    <br>
				    Server: <input type="text" name="app_server" id="app_server" value="https://nlpcloudpipeline.azurewebsites.net/">
				    <br>
				    # Channels: <input type="text" name="num_channels" id="num_channels" value="1">
				    <br>
				    <button type="submit" class="btn btn-primary btn-block" name="submit"> Interpret Audio</button>
                 
                </form>
            </td>
        </tr>
        </table>
    </div> 
    
    
</body>
</html>