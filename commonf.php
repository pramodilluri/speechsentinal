<?php

function insertAnalysisLog($audioText,$sentimentResult,$link) {
    //FINALLY, create an entry in the Events Log
   
    //echo "Ready to create an entry in the Events Log. ". $_SESSION["username"] . "<br>";
    // Prepare an insert statement
    $sql = "INSERT INTO sentimentAnalysis (audioText, sentimentResult) VALUES (?, ?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_eventdescription, $param_eventusername);
        
        // Set parameters
        //$param_eventdescription = "User ". $_SESSION["username"] . " created the List: ". $listname ."!"; 
        $param_eventdescription = $audioText;
        //$param_eventusername = $_SESSION["username"];
        $param_eventusername = $sentimentResult;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
         //   // Redirect to login page
           // header("location: login.php");
           echo("<br>Analysis Log entry created!<br>");
        } else {
           echo "Something went wrong when inserting an entry in the Event Log. Please try again later."; 
        }
        
         // Close statement
        mysqli_stmt_close($stmt);
           
    }
}

function insertEventLog($message,$messenger,$link) {
                //FINALLY, create an entry in the Events Log
               
                //echo "Ready to create an entry in the Events Log. ". $_SESSION["username"] . "<br>";
                // Prepare an insert statement
                $sql = "INSERT INTO eventsLog (eventDescription, eventUsername) VALUES (?, ?)";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ss", $param_eventdescription, $param_eventusername);
                    
                    // Set parameters
                    //$param_eventdescription = "User ". $_SESSION["username"] . " created the List: ". $listname ."!"; 
                    $param_eventdescription = $message;
                    //$param_eventusername = $_SESSION["username"];
                    $param_eventusername = $messenger;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                     //   // Redirect to login page
                       // header("location: login.php");
                       //echo("<br>Event Log entry created!<br>");
                    } else {
                       echo "Something went wrong when inserting an entry in the Event Log. Please try again later."; 
                    }
                    
                     // Close statement
                    mysqli_stmt_close($stmt);
                       
                }
}

function createComment($lstId,$comment,$publisher,$link) {
                //create a comment
               
                //echo "Ready to create a comment <br>";
                // Prepare an insert statement
                $sql = "INSERT INTO Comments (cmtLstId,comment,cmtUsername) VALUES (?, ?, ?)";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "iss", $param_cmtlstid,$param_comment,$param_cmtusername);
                    
                    // Set parameters
                    $param_cmtlstid = $lstId;
                    $param_comment = $comment;
                    $param_cmtusername = $publisher;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                     //   // Redirect to login page
                       // header("location: login.php");
                       //echo("<br>Comment created!<br>");
                    } else {
                       echo "Something went wrong when inserting an entry in the Event Log. Please try again later."; 
                    }
                    
                     // Close statement
                    mysqli_stmt_close($stmt);
                       
                }
}

function doLike($lstId,$username,$link) {
                //create a comment
               
                //echo "Ready to like <br>";
                // Prepare an insert statement
                $sql = "INSERT INTO Likes (likeLstId,likeUsername) VALUES (?, ?)";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "is", $param_cmtlstid,$param_cmtusername);
                    
                    // Set parameters
                    $param_cmtlstid = $lstId;
                    $param_cmtusername = $username;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                     //   // Redirect to login page
                       // header("location: login.php");
                       //echo("<br>Like recorded!<br>");
                       return "";
                    } else {
                       //echo "Something went wrong when inserting a Like. Please try again later."; 
                       $header_error = "A user can like a List just once!";
                       return $header_error;
                    }
                    
                     // Close statement
                    mysqli_stmt_close($stmt);
                       
                }
}

function requestPartPermission($again,$permLstId,$permusername,$permusernameto,$link) {
            if ($again==0) {
                        // Prepare an insert statement
                        $sql = "INSERT INTO permRequests (permLstId,permUsername,permUsernameTo) VALUES (?, ?, ?)";
                        //echo "List=".$permLstId." username:".$permusername." permusernameto: ".$permusernameto."<br>";
                        //echo $sql."<br>";
                         
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "iss", $param_listid, $param_permusername, $param_permusernameto);
                            
                            // Set parameters
                            $param_listid = $permLstId;
                            $param_permusername = $permusername;
                            $param_permusernameto = $permusernameto;
                           
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                             //   // Redirect to login page
                               // header("location: login.php");
                               //echo("<br>Permission Request sent to ".$permusername."! Please wait for <b>" . $permusername . "</b> to respond...<br>");
                            } else{
                                //echo "Permission was already requested or granted on this List.";
                            }
                            
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            
                            //echo "Permission was already requested or granted on this List.";
                            mysqli_stmt_close($stmt);
                        }
                    }
                    else {
                    
                        //echo "update statement <br>";
                        // Prepare an insert statement
                            $sql = "UPDATE permRequests SET permStatus=0 WHERE permLstId=? and permUsername=? and permUsernameTo=?";
                             
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "iss", $param_listid, $param_permusername, $param_permusernameto);
                                
                                // Set parameters
                                $param_listid = $permLstId;
                                $param_permusername = $permusername;
                                $param_permusernameto = $permusernameto;
                               
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                 //   // Redirect to login page
                                   // header("location: login.php");
                                   //echo("<br>Permission Request sent to ".$permusername."! Please wait for <b>" . $permusername . "</b> to respond...<br>");
                                } else{
                                    echo "Something went wrong. Please try again!";
                                }
                                
                                // Close statement
                                mysqli_stmt_close($stmt);
                            } else {
                                
                                echo "Something went wrong. Please try again!";
                                mysqli_stmt_close($stmt);
                            }
                    }
}

function addItemToList($addtolistId,$itemname,$itemdescription,$lstowner,$link) {
    //Add an Item to a List
    
    //echo ("<br>Ready to insert an Item record into List # " . $addtolistId . " for the username " . $lstowner ." item name=". $itemname . " description=". $itemdescription ."!<br>");
                    
                    //Create an Item record for that list
                                    // Prepare an insert statement
                                    $sql = "INSERT INTO Items (itemLstId, itemName, itemDescription, itemUsername) VALUES (?, ?, ?, ?)";
                                     
                                    if($stmt = mysqli_prepare($link, $sql)){
                                        // Bind variables to the prepared statement as parameters
                                        mysqli_stmt_bind_param($stmt, "isss", $param_itemLstId, $param_itemName, $param_itemDescription, $param_itemUsername);
                                        
                                        // Set parameters
                                        $param_itemLstId = $addtolistId;
                                        $param_itemName = $itemname;
                                        $param_itemDescription = $itemdescription;
                                        $param_itemUsername = $lstowner;
                                        
                                        // Attempt to execute the prepared statement
                                        if(mysqli_stmt_execute($stmt)){
                                            //echo "Item created!<br>";
                                        } else{
                                            echo "Something went wrong when creating an Item. Please try again later.";
                                        }
                                        //echo("<br>stmt: " . $stmt);
                                        // Close statement
                                        mysqli_stmt_close($stmt);
                                    } else {
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                 
}

function createList($username,$userid,$listname,$listdescription,$listtype,$itemname,$itemdescription,$itemusername,$link) {
        echo ("<br>Ready to insert a List record for " & $_SESSION["username"] & "!<br>");
        
        // Prepare an insert statement
        $sql = "INSERT INTO lists (lstOwnerUsername, lstName, lstDesc, lstType) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_listownerusername, $param_listname, $param_listdescription, $param_listtype);
            
            // Set parameters
            $param_listownerusername = $username;
            $param_listname = $listname;
            $param_listdescription = $listdescription;
            $param_listtype = $listtype;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
             //   // Redirect to login page
               // header("location: login.php");
               //echo("<br>List created!<br>");
               
                
               
            } else{
                echo "Something went wrong when inserting a List. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Prepare a select statement
        $sql = "SELECT max(lstId) FROM lists WHERE lstOwnerUsername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            // Set parameters
            $param_username = $username;
            
            //echo "<br>looking for last List of: <br>" . $param_username; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if list exists
                if(mysqli_stmt_num_rows($stmt) > 0) {                    
                        //echo ("<br>Latest List found for that username!!!<br>");
                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $lstLstId);
                        if(mysqli_stmt_fetch($stmt)){
                            //echo "<br>Latest List found for that username!!!<br>" . $lstLstId;
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                        //Create a relationship record for that list and user
                        // Prepare an insert statement
                        $sql = "INSERT INTO relListsUsers (lstId, userId) VALUES (?, ?)";
                         
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "ii", $param_listid, $param_userid);
                            
                            // Set parameters
                            $param_userid = $userid;
                            $param_listid = $lstLstId;
                            
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                             //   // Redirect to login page
                               // header("location: login.php");
                               //echo("<br>Relationship created!<br>");
                            } else{
                                echo "Something went wrong when creating relationship list-user. Please try again later.";
                            }
                            //echo("<br>stmt: " & $stmt);
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                        //Create an Item record for that list
                        // Prepare an insert statement
                        $sql = "INSERT INTO Items (itemLstId, itemName, itemDescription, itemUsername) VALUES (?, ?, ?, ?)";
                         
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "isss", $param_itemLstId, $param_itemName, $param_itemDescription, $param_itemUsername);
                            
                            // Set parameters
                            $param_itemLstId = $lstLstId;
                            $param_itemName = $itemname;
                            $param_itemDescription = $itemdescription;
                            $param_itemUsername = $username;
                            
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                             
                               //echo("<br>Item created!<br>");
                            } else{
                                echo "Something went wrong when creating an Item. Please try again later.";
                            }
                            //echo("<br>stmt: " . $stmt);
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                    }
                else {
                    // Display an error message if username doesn't exist
                    $username_err = "No List found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                // Close statement
                mysqli_stmt_close($stmt);
            }
            
        } 
        else{
                echo "Oops! Something went wrong. Please try again later.";
                // Close statement
                mysqli_stmt_close($stmt);
        }
}

function createList2($username,$userid,$listname,$listdescription,$listtype,$itemname,$itemdescription,$link) {
        //echo ("<br>Ready to insert a List record for " & $_SESSION["username"] & "!<br>");
        
        // Prepare an insert statement
        $sql = "INSERT INTO lists (lstOwnerUsername, lstName, lstDesc, lstType) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_listownerusername, $param_listname, $param_listdescription, $param_listtype);
            
            // Set parameters
            $param_listownerusername = $username;
            $param_listname = $listname;
            $param_listdescription = $listdescription;
            $param_listtype = $listtype;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
             //   // Redirect to login page
               // header("location: login.php");
               //echo("<br>List created!<br>");
               
                
               
            } else{
                echo "Something went wrong when inserting a List. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Prepare a select statement
        $sql = "SELECT max(lstId) FROM lists WHERE lstOwnerUsername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            // Set parameters
            $param_username = $username;
            
            //echo "<br>looking for last List of: <br>" . $param_username; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if list exists
                if(mysqli_stmt_num_rows($stmt) > 0) {                    
                        //echo ("<br>Latest List found for that username!!!<br>");
                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $lstLstId);
                        if(mysqli_stmt_fetch($stmt)){
                            //echo "<br>Latest List found for that username!!!<br>" . $lstLstId;
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                        //Create a relationship record for that list and user
                        // Prepare an insert statement
                        $sql = "INSERT INTO relListsUsers (lstId, userId) VALUES (?, ?)";
                         
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "ii", $param_listid, $param_userid);
                            
                            // Set parameters
                            $param_userid = $userid;
                            $param_listid = $lstLstId;
                            
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                             //   // Redirect to login page
                               // header("location: login.php");
                               //echo("<br>Relationship created!<br>");
                            } else{
                                echo "Something went wrong when creating relationship list-user. Please try again later.";
                            }
                            //echo("<br>stmt: " & $stmt);
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                        //Create an Item record for that list
                        addItemToList($lstLstId,$itemname,$itemdescription,$username,$link);
                    }
                else {
                    // Display an error message if username doesn't exist
                    $username_err = "No List found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                // Close statement
                mysqli_stmt_close($stmt);
            }
            
        } 
        else{
                echo "Oops! Something went wrong. Please try again later.";
                // Close statement
                mysqli_stmt_close($stmt);
        }
}

function createList3($username,$userid,$listname,$listdescription,$listtype,$listduedate,$listcategory,$itemname,$itemdescription,$link) {
        //echo ("<br>Ready to insert a List record for " & $_SESSION["username"] & "!<br>");
        
        // Prepare an insert statement
        $sql = "INSERT INTO lists (lstOwnerUsername, lstName, lstDesc, lstType, lstDueDate, lstCategoryId) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssisi", $param_listownerusername, $param_listname, $param_listdescription, $param_listtype, $param_listduedate, $param_listcategory);
        
            //echo "due date to register: ".$listduedate."<br>";
            // Set parameters
            $param_listownerusername = $username;
            $param_listname = $listname;
            $param_listdescription = $listdescription;
            $param_listtype = $listtype;
            $param_listduedate = $listduedate;
            $param_listcategory = $listcategory;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
             //   // Redirect to login page
               // header("location: login.php");
               //echo("<br>List created!<br>");
               
                
               
            } else{
                echo "Something went wrong when inserting a List. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Prepare a select statement
        $sql = "SELECT max(lstId) FROM lists WHERE lstOwnerUsername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            // Set parameters
            $param_username = $username;
            
            //echo "<br>looking for last List of: <br>" . $param_username; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if list exists
                if(mysqli_stmt_num_rows($stmt) > 0) {                    
                        //echo ("<br>Latest List found for that username!!!<br>");
                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $lstLstId);
                        if(mysqli_stmt_fetch($stmt)){
                            //echo "<br>Latest List found for that username!!!<br>" . $lstLstId;
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                        //Create a relationship record for that list and user
                        // Prepare an insert statement
                        $sql = "INSERT INTO relListsUsers (lstId, userId) VALUES (?, ?)";
                         
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "ii", $param_listid, $param_userid);
                            
                            // Set parameters
                            $param_userid = $userid;
                            $param_listid = $lstLstId;
                            
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                             //   // Redirect to login page
                               // header("location: login.php");
                               //echo("<br>Relationship created!<br>");
                            } else{
                                echo "Something went wrong when creating relationship list-user. Please try again later.";
                            }
                            //echo("<br>stmt: " & $stmt);
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                        // Close statement
                        mysqli_stmt_close($stmt);
                        
                        //Create an Item record for that list
                        addItemToList($lstLstId,$itemname,$itemdescription,$username,$link);
                    }
                else {
                    // Display an error message if username doesn't exist
                    $username_err = "No List found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                // Close statement
                mysqli_stmt_close($stmt);
            }
            
        } 
        else{
                echo "Oops! Something went wrong. Please try again later.";
                // Close statement
                mysqli_stmt_close($stmt);
        }
}

function fecthEvents($resultset,$link) {
    
    // fecth notifications from the Events Log
    //Fetch items for this list
    // Prepare a select statement
    $sql = "SELECT * FROM eventsLog ORDER BY created_at DESC";
    //echo $sql."<br>";
    return $resultset;
}

function fetchListItems($lstId,$link) {
    
    //Executing the multi query
   $sql = "SELECT itemId,itemName,itemDescription,itemStatus,itemUsername FROM Items WHERE itemLstId=". $lstId . " ORDER BY created_at DESC";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
       //$resultset = mysqli_fetch_array($res);
      //while ($row = mysqli_fetch_row($res)) {
        // print("Name: ".$row[0]."\n");
        // print("Age: ".$row[1]."\n");
      //}
      return $res;
   } else {
       return null;
   }

   //Closing the connection
   //mysqli_close($con);
}

function fetchEvents($limit,$link) {
    
    //Executing the multi query
    if (!empty($limit)) {
        if ($limit>0) {
            $sql = "SELECT * FROM eventsLog ORDER BY created_at DESC LIMIT 0, ".$limit;
        } else {
            $sql = "SELECT * FROM eventsLog ORDER BY created_at DESC";
        }
    } else {
        $sql = "SELECT * FROM eventsLog ORDER BY created_at DESC";
    }
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
       //$resultset = mysqli_fetch_array($res);
      //while ($row = mysqli_fetch_row($res)) {
        // print("Name: ".$row[0]."\n");
        // print("Age: ".$row[1]."\n");
      //}
      return $res;
   } else {
       return null;
   }

   //Closing the connection
   //mysqli_close($con);
}

function countComments($lstId,$link) {
    
    //Executing the multi query
   $sql = "SELECT count(*) FROM Comments WHERE cmtLstId=". $lstId;
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
       //$resultset = mysqli_fetch_array($res);
      //while ($row = mysqli_fetch_row($res)) {
        // print("Name: ".$row[0]."\n");
        // print("Age: ".$row[1]."\n");
      //}
      return $res;
   } else {
       return null;
   }

   //Closing the connection
   //mysqli_close($con);
}

function countLikes($lstId,$link) {
    
    //Executing the multi query
   $sql = "SELECT count(*) FROM Likes WHERE likeLstId=". $lstId;
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
       //$resultset = mysqli_fetch_array($res);
      //while ($row = mysqli_fetch_row($res)) {
        // print("Name: ".$row[0]."\n");
        // print("Age: ".$row[1]."\n");
      //}
      return $res;
   } else {
       return null;
   }

   //Closing the connection
   //mysqli_close($con);
}

function countParticipants($lstId,$link) {
    
    //Retrieve the # of participants on a List
    
    //Executing the multi query
   $sql = "SELECT count(*) FROM permRequests WHERE permLstId=". $lstId ." and permStatus=1";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function fetchLists($typeoflists,$limit,$canparticipate,$username,$link) {
    
    //Retrieve Public or My Lists
    
    //Executing the multi query
    if ($typeoflists=="P") {
        if (empty($canparticipate) || $canparticipate==0) {
            if (empty($limit) || $limit==0) {
            $sql = "SELECT * FROM lists,users WHERE lstType=1 and lstOwnerUsername<>'" . $username . "' and lstOwnerUsername=username ORDER BY lists.created_at DESC";
            } else {
               $sql = "SELECT * FROM lists,users WHERE lstType=1 and lstOwnerUsername<>'" . $username . "' and lstOwnerUsername=username ORDER BY lists.created_at DESC LIMIT 0,".$limit; 
            }
        } else {
            //retrieve the public lists a user can participate on
            if (empty($limit) || $limit==0) {
            $sql = "SELECT * FROM lists,permRequests WHERE lstType=1 and lstId=permLstId and lstOwnerUsername<>'" . $username . "' and permUsernameTo='".$username."' and permStatus=1 ORDER BY lists.created_at DESC";
            } else {
                $sql = "SELECT * FROM lists,permRequests WHERE lstType=1 and lstId=permLstId and lstOwnerUsername<>'" . $username . "' and permUsernameTo='".$username."' and permStatus=1 ORDER BY lists.created_at DESC LIMIT 0,".$limit;
            }
        }
    } elseif ($typeoflists=="M") {
        if (empty($limit) || $limit==0) {
        $sql = "SELECT * FROM lists,users WHERE lstOwnerUsername='" . $username . "' and lstOwnerUsername=username ORDER BY lists.created_at DESC ";
        } else {
           $sql = "SELECT * FROM lists,users WHERE lstOwnerUsername='" . $username . "' and lstOwnerUsername=username ORDER BY lists.created_at DESC LIMIT 0,".$limit; 
        }
    } else {
        if (empty($limit) || $limit==0) {
        $sql = "SELECT * FROM lists WHERE lstType=1 and lstOwnerUsername<>'" . $username . "' ORDER BY lists.created_at DESC";
        } else {
            $sql = "SELECT * FROM lists WHERE lstType=1 and lstOwnerUsername<>'" . $username . "' ORDER BY lists.created_at DESC LIMIT O,".$limit;
        }
    }
   
   //echo $sql."<br>";
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function findLists($text2search,$link) {
    
    //Find lists based on a search text
    
    //Executing the multi query
   $sql = "SELECT * FROM lists, users, Categories WHERE lstOwnerUsername=username and (lstName like '%". $text2search ."%' or lstDesc like '%".$text2search."%') and lstCategoryId=categoryId ORDER BY lists.created_at DESC";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function fecthLastComment($lstId,$link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
   $sql = "SELECT comment, Comments.created_at as created_at, photo FROM Comments, users WHERE cmtLstId=".$lstId." and cmtUsername=username ORDER BY Comments.created_at DESC LIMIT 0,1";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function fetchListData($lstId,$link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
   $sql = "SELECT lstId,lstName,lstDesc,lstType,photo,lists.created_at AS created_at,lstOwnerUsername,categoryName FROM lists, users, Categories WHERE lstId=".$lstId." and lstOwnerUsername=username and lstCategoryId=categoryId";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function fetchComments($lstId,$link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
   $sql = "SELECT idCmnt,comment,cmtUsername,Comments.created_at AS created_at,photo FROM Comments, users WHERE cmtLstId=".$lstId." AND cmtUsername = username ORDER BY Comments.created_at DESC";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function deleteComment($cmtid,$link) {
                //delete a comment
               
                //echo "Ready to like <br>";
                // Prepare an insert statement
                $sql = "DELETE FROM Comments WHERE idCmnt = ?";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "i", $param_cmtid);
                    
                    // Set parameters
                    $param_cmtid = $cmtid;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                     //   // Redirect to login page
                       // header("location: login.php");
                       //echo("<br>Like recorded!<br>");
                    } else {
                       echo "Something went wrong when deleting a comment. Please try again later."; 
                    }
                    
                     // Close statement
                    mysqli_stmt_close($stmt);
                       
                }
}

function deleteItem($itemid,$link) {
                //delete a comment
               
                //echo "Ready to like <br>";
                // Prepare an insert statement
                $sql = "DELETE FROM Items WHERE itemId = ?";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "i", $param_itemid);
                    
                    // Set parameters
                    $param_itemid = $itemid;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                     //   // Redirect to login page
                       // header("location: login.php");
                       //echo("<br>Like recorded!<br>");
                    } else {
                       echo "Something went wrong when deleting an Item. Please try again later."; 
                    }
                    
                     // Close statement
                    mysqli_stmt_close($stmt);
                       
                }
}

function updateItem($itemid,$itemname,$itemdescription,$itemstatus,$link) {
                //update and Item
               
                //echo "Ready to like <br>";
                // Prepare an insert statement
                $sql = "UPDATE Items SET itemName = ?, itemDescription = ?, itemStatus = ? WHERE itemId = ?";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssii", $param_itemname,$param_itemdescription,$param_itemstatus,$param_itemid);
                    
                    // Set parameters
                    $param_itemname = $itemname;
                    $param_itemdescription = $itemdescription;
                    $param_itemstatus = $itemstatus;
                    $param_itemid = $itemid;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                     //   // Redirect to login page
                       // header("location: login.php");
                       //echo("<br>Like recorded!<br>");
                    } else {
                       echo "Something went wrong when updating an Item. Please try again later."; 
                    }
                    
                     // Close statement
                    mysqli_stmt_close($stmt);
                       
                }
}

function canParticipate($lstId,$permusernameto,$link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
   $sql = "SELECT permStatus FROM permRequests WHERE permLstId=".$lstId." AND permUsernameTo ='".$permusernameto."'";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      if(mysqli_num_rows($res) > 0) {
          $row2 = mysqli_fetch_array($res);
          return $row2[0];
          //return 1;
      } else {
          return -1;
      }
   } else {
       return -1;
   }

}

function countItemsPerStatus($lstid,$itemstatus,$link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
    if ($itemstatus==-1) {
        $sql = "SELECT count(*) FROM Items WHERE itemLstId=".$lstid;
    } else {
        $sql = "SELECT count(*) FROM Items WHERE itemLstId=".$lstid." AND itemStatus=".$itemstatus;
    }
   
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      if(mysqli_num_rows($res) > 0) {
          $row2 = mysqli_fetch_array($res);
          return $row2[0];
          //return 1;
      } else {
          return -1;
      }
   } else {
       return -1;
   }

}

function fetchCategories($link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
   $sql = "SELECT categoryId,categoryName,categoryDescription FROM Categories ORDER BY created_at DESC";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}

function fetchPermRequestors($lstId,$link) {
    
    //Find the last comment posted on a List
    
    //Executing the multi query
   $sql = "SELECT permLstId,permStatus,permUsernameTo FROM permRequests WHERE permLstId=".$lstId." ORDER BY created_at DESC";
   //echo $sql;
   
   //Retrieving the records
   $res = mysqli_query($link, $sql);
   if ($res) {
      return $res;
   } else {
       return null;
   }

}
?>