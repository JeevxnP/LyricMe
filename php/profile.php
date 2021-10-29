<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/profile.css">
        <link rel="stylesheet" type="text/css" href="../css/menubar.css">
        <title>Profile</title>
    </head>
    <body style="background-color: rgb(255, 255, 255);">
    <?php
       // session_start();
       // require_once('menubar.php');
    ?>
        <p class="heading">Profile</p>

         <svg id="Group_1" data-name="Group 1" xmlns="http://www.w3.org/2000/svg" width="360" height="360" viewBox="0 0 360 360">
            <circle id="Ellipse_1" data-name="Ellipse 1" cx="180" cy="180" r="180" fill="#ebebeb"/>
            <path id="solid_user" data-name="solid user" d="M76.7,87.662A43.831,43.831,0,1,0,32.873,43.831,43.828,43.828,0,0,0,76.7,87.662ZM107.386,98.62h-5.719a59.609,59.609,0,0,1-49.926,0H46.023A46.034,46.034,0,0,0,0,144.642v14.245a16.441,16.441,0,0,0,16.437,16.437H136.972a16.441,16.441,0,0,0,16.437-16.437V144.642A46.034,46.034,0,0,0,107.386,98.62Z" transform="translate(103.296 92.338)"/>
          </svg>
      <?php
        include("accountForm.php");
      ?>
    </body>
</html>
