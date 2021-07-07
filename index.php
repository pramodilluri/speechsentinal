<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'index_test.php';
      break; 
   case '/GCPaudiointerpreterAzure2.php':     // if you plan to also allow a URL with the file name 
      require 'GCPaudiointerpreterAzure2.php';
      break;              
   case '/index4.html':
      require 'index4.html';
      break;
   case '/speechtotext_gcp.html':
        require 'speechtotext_gcp.html';
        break;
   case '/speechtotext_azure.html':
        require 'speechtotext_azure.html';
        break;
   default:
      http_response_code(404);
      exit('Not Found');
}  
?>
