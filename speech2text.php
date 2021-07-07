<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Lists</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Search</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($seacrhtext_err)) ? 'has-error' : ''; ?>">
                <label>Please enter your search text:</label>
                <input type="text" name="searchtext" class="form-control" value="<?php echo $searchtext; ?>">
                <span class="help-block"><?php echo $searchtext_err; ?></span>
            </div>    
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </form>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($seacrhfile_err)) ? 'has-error' : ''; ?>">
                <label>... Or, a .WAV file name:</label>
                <input type="text" name="searchfile" class="form-control" value="<?php echo $searchfile; ?>">
                <span class="help-block"><?php echo $searchfile_err; ?></span>
            </div>    
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </form>
    </div> 
    
    <?php

    echo "<hr>";
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
        // Check if username is empty
        if(empty(trim($_POST["searchtext"])) && empty(trim($_POST["searchfile"]))){
            if (empty(trim($_POST["searchtext"]))) {
                $searchtext_err = "Please enter search text";
            } 
            if(empty(trim($_POST["searchfile"]))) {
                $searchfile_err = "Please enter a file name to interpret";
            }
        } else {
            
            if (!empty(trim($_POST["searchtext"]))) {
                //Look for the text in the database directly
                
                $text2search = trim($_POST["searchtext"]);
                echo "Search for this text in the dB: " . $text2search . "<br>";
                
            } else {
                //First, interpret the audio file to get the text to search
                $file2interpret = trim($_POST["searchfile"]);
                echo "File to interpret: " . $file2interpret . "<br>";
                
                $googlespeechURL = "https://speech.googleapis.com/v1p1beta1/speech:recognize?key=AIzaSyDxhGZZpY4RI3xYr28fpWeyzgpDduo3wFo";
                $filedata = file_get_contents("http://rafcmuexperience.com/". $file2interpret);
                
                $data = array(
                    "config" => array(
                        "encoding" => "LINEAR16",
                        //"sample_rate_hertz" => 16000,
                        "language_code" => "en-US"
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
                echo "Search for this text in the dB (from the audio interpretation): " . $text2search . "<br>";
                echo "Ok!";
            }
        }
        
    }
    
    echo "<hr>";
    ?>
</body>
</html>