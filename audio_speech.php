<!DOCTYPE html>

<?php

    $result_array = array();
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
       // Check input errors before calling the API
        $upload_err = "";
        if(empty($upload_err)) {
            
            $target_dir = "";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            #echo "Image File Name = " .  $target_file . "<br>";
            #echo "Image File Type = " .  $imageFileType . "<br>";
            
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
                #echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
            }
            
            if ($uploadOk==1) {
                #echo "The audio file was SUCCESSFULLY uploaded...<Br>";
                
                //$file2interpret = "uploads/".htmlspecialchars(basename( $_FILES["fileToUpload"]["name"]));
                $file2interpret = htmlspecialchars(basename( $_FILES["fileToUpload"]["name"]));
                $app_server = $_POST["app_server"];
                $num_channels = $_POST["num_channels"];
                
                //Call the GCP SpeechToText API
                #echo "APP server: " . $app_server . "<br>";
                #echo "<b>File to interpret: " . $file2interpret . "</b><br>";
                #echo "<b># Channels: " . $num_channels . "</b><br>";
                
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
               // echo $result . "<br>";
                $result_array = json_decode($result, true);
                
               /* echo "Transcript: " . $result_array["results"][0]["alternatives"][0]["transcript"] . "<br>";
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
                */
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
			display: none;
		}
		.upload-btn-wrapper {
		  position: relative;
		  overflow: hidden;
		  display: inline-block;
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
  
  <div id="content"  class="container">
	<div class="col-md-12  mt-4">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
			<div class="p-2" style="text-align:center" id="uploadFile"></div>
            <div class=" d-flex mt-2" style="justify-content: center;">   
					
					<div class="upload-btn-wrapper" style="margin-right: 10px">
					  <button class="btn">Upload a file</button>
					  <input type="file" name="fileToUpload" id="fileToUpload">
					</div>
				
					<button type="submit" class="btn btn-primary" name="submit"> Interpret Audio</button>
				</div>
			</div>
			<div class="col-md-12 mt-3">
				<div id="response" class="form-control mt-3" style="height: 200px; border: 1px solid #ccc" placeholder="Result"><b><?php if(count($result_array) > 0) { echo $result_array["results"][0]["alternatives"][0]["transcript"]; } ?></b></div>
			</div>
			
		</form>
		<form action="sentimentAnalyzer.php" method="POST" enctype="multipart/form-data">
			<textarea name="text_to_analyze" id="text_to_analyze" class="d-none"><?php if(count($result_array) > 0) { echo $result_array["results"][0]["alternatives"][0]["transcript"]; } ?></textarea>
			<div class="col-md-12 text-center mt-3"><button id="analyseButton" type="submit" class="btn btn-primary btn-block" name="submit"><i class="fa fa-analyze"></i> Analyze Sentiment</button></div>
		</form>
	</div>
  </div>
  <script>
	var input = document.getElementById( 'fileToUpload' );
	var infoArea = document.getElementById( 'uploadFile' );

	input.addEventListener( 'change', showFileName );

	function showFileName( event ) {
	  var input = event.srcElement;
	  var fileName = input.files[0].name;
	  infoArea.textContent = 'Selected File name: ' + fileName;
	}
  </script>
</body>
    
</html>
