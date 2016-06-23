<?php


if ($_COOKIE["id"]){
    header("Location: loggedIn.php");
} 

//DB Variables
$host = "localhost";
$db = "mehdi_practice";
$table = "allUsers";
$username = "root";
$password = "root";

if($_GET['signup']==1){
    $hidden = false;
    $error = "";
    if ($_POST){
        if($_POST["name"] == ""){
            $error .= "<strong><span style='color:red'>Name</strong></span><br>";
        } 
        if($_POST["email"] == ""){
            $error .= "<strong><span style='color:red'>Email</strong></span><br>";
        }
        if ($_POST["password"] == ""){
            $error .= "<strong><span style='color:red'>Password</strong></span><br>";
        }
        
        if ($error == ""){
            //Attempt the Sign Up Process
            $link = mysqli_connect($host, $username, $password, $db);
            if(mysqli_connect_error()){
                $error = "Database Error, Please trying signing up again later.";
            }
            $query = "SELECT email FROM $table WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0){
                $error .= "<p style='color:red'><strong>That email is already in use. Please loggin if you already have an account.</p>";
            } else {
                // First Encrypt Password, Then Sign Up
                $userPassword = md5($_POST["password"]);
                $query = "INSERT INTO $table (Name, Email, Password, Type) VALUES ('$_POST[name]','$_POST[email]','$userPassword', 'user');";
                if (mysqli_query($link, $query)){
                    $error = "<p style='color:green'>You have been successfully added to the system. Please proceed to loggin</p>";
                    //header('Location: index.php');
                } else {
                    $error = "<p style='color:red'><strong>System Error</p>";
                }
            }
            
        } else {
            $error = "The Following Required Field(s) are missing: <br>"."$error";
        }
    }
}else {
    $hidden = true;
    $error = "";
    //Loggin
    $error = "";
    if ($_POST){
        if($_POST["email"] == ""){
            $error .= "<strong><span style='color:red'>Email</strong></span><br>";
        } 
        if($_POST["password"] == ""){
            $error .= "<strong><span style='color:red'>Password</strong></span><br>";
        }
        if ($error == ""){
            //Attempt Loggin
            $link = mysqli_connect($host, $username, $password, $db);
            if(mysqli_connect_error()){
                $error = "Database Error, Please trying signing up again later.";
            }
            $query = "SELECT * FROM $table WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) == 0){
                $error .= "<p style='color:red'><strong>That email is NOT in the system. Please enter a valid email.</p>";
            }
            $row = mysqli_fetch_array($result);
            if ($row["Password"] == $_POST["password"]){
                if($_POST["remainLoggedIn"]==1){
                    setcookie("id",$_POST["email"],time()+60*5);
                }
            }else {
                $error .= "<p style='color:red'><strong>Invalid Password</strong>.</p>";
            }
        } else {
            $error = "The Following Required Field(s) are missing: <br>"."$error";
        }  
    }
}

$styleForMenu = "";
$messageForMenu = "";
$signUpMessage = "";
$currentType = "";

switch ($hidden) {
    case true:
        $messageForMenu = "Please sign in below.";
        $styleForMenu = "style='display:none'";
        $signUpMessage = '<p style="font-style: italic;color:blue">Not a Member? Click <a href="http://localhost:8888/7-mysql/simpleLogginSystem/?signup=1">here</a> to Sign Up!</p>';
        $currentType = "Loggin";
        break;
    default:
        $messageForMenu = "Please enter your information below to sign up and gain access.";
        $signUpMessage = '<p style="font-style: italic;color:blue">Already a Member? Click <a href="http://localhost:8888/7-mysql/simpleLogginSystem/">here</a> to Loggin!</p>';
        $currentType = "Sign Up";
        break;
}

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
    
      <style type="text/css">
      
          body {
              background-image: url(mainBG.jpg);
              background-size: cover;
              align-content: center;
              text-align: center;
          }
          
          
      </style>
      
      
      
      
  </head>
    
  <body>
      
      
      <div class="container" style="padding:5%;">
        <div class="row">
            <div class="jumbotron col-sm-12">
                <h1 class="display-3">Welcome</h1>
                <p><strong><? echo $messageForMenu ?></strong></p>
                <p> <? echo $error ?></p>
                <form method="post">
                    <? echo $signUpMessage ?>
                    <br>
                    
                    <fieldset class="form-group" <? echo $styleForMenu ?> >
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Passowrd" name="password">
                    </fieldset>
                    <button type="submit" class="btn btn-primary">
                        <? echo $currentType ?>
                    </button>
                    <label>
                        <input type="checkbox" id="stayLoggedIn" value=1 name="remainLoggedIn">
                        Remain Logged In?
                    </label>
                </form>
                
            </div>
        </div>
      </div>
      
      <? echo $cookieMessage ?>
      
      
      
      
      <!-- jQuery first, then Bootstrap JS. -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
    
</html>
