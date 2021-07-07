<?php
$googlespeechURL = "https://speech.googleapis.com/v1p1beta1/speech:recognize?key=AIzaSyDxhGZZpY4RI3xYr28fpWeyzgpDduo3wFo";
$filedata = file_get_contents("http://rafcmuexperience.com/2.wav");

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

echo "Ok!";

?>