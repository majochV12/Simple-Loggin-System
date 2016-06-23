<?php

if ($_POST["logout"]){
    setcookie("id","0",time()-300);
    header("Location: index.php");
}

print_r($_SESSION);

//DB Variables
$host = "localhost";
$db = "mehdi_practice";
$table = "allUsers";
$username = "root";
$password = "root";

$link = mysqli_connect($host, $username, $password, $db);
if(mysqli_connect_error()){
    $error .= "Database Error, Please trying signing up again later.";            
}

$id = $_COOKIE["id"];
$query = "SELECT * FROM allUsers WHERE email = '$id';";

$result = mysqli_query($link, $query);
if (mysqli_num_rows($result) == 0){
    $error .= "RESULT ERROR";
}

$row = mysqli_fetch_array($result);
echo $row["Id"];
echo $row["Name"];
echo $row["Email"];
echo $row["Password"];
echo $row["Type"];

?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <!-- Required meta tags always come first -->
    
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
    
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
  
    </head>
  
    <body>
        <h1>Hello USER <? echo $_COOKIE["id"] ?></h1>
        <p><? echo $error ?></p>

        <!-- jQuery first, then Bootstrap JS. -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
    </body>
    
    
</html>
