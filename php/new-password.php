<?php
    session_start();
    // validating the url
    $selector = $_SESSION['selector'];
    $validator = $_SESSION['validator'];
    // change to corresponding path for demo
    $login = "http://localhost/lyric-me/php/login-index.php";

    if (empty($selector) || empty($validator)) {
        echo "<script type='text/javascript'>alert('Could not validate your request!');
              window.location.replace('" . $login . "');</script>";
    }
    // verifying variable is in hex data type
    else if (ctype_xdigit($selector) && ctype_xdigit($validator)){ 
        include('token-selector-verified.php');
    }
    else{
        echo "<script type='text/javascript'>alert('Could not validate your request!');
              window.location.replace('" . $login . "');</script>";
    }
    include('token-selector-verified.php');
 ?>