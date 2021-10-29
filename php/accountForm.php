<?php
session_start();
// lines below are the session variables
// $_SESSION['username']
// $_SESSION['full_name']
// $_SESSION['email']
// $_SESSION['account_type']
// $_SESSION['points']
// $_SESSION['created_at']

// username, email and points should be loaded into different read-only input boxes

// full name loaded into a read and write input box
// new full name cannot be empty and has to be less than 100chars
// if user doesn't want to change the full name then they don't need to edit the value in the inputbox

// there should be two empty input boxes 'Change password' and 'Confirm password'
// password strength authentication template in 'new-password-submit.php' line 50 and onwards

// only update if both full name and password are authenticated

// user should also be able to see their points
// there should be links to the threads that the user created 
// there should be links to the threads where the user left a comment 

    function getInput() {
      $startForm = "<form action='$_SERVER[PHP_SELF]' method='POST'>";
        // // <label for="account">Account:</label><br>
        // $inputUser = "<input type='text' name='Username'>";
        // <label for="name">Full name:</label><br>
        $inputName = "<input type='text' name='Name'>";
        // <label for="Email">Email:</label><br>
        $inputEmail = "<input type='email' name='Email'>";
        // <label for="password">Password:</label><br>
        $inputPassword = "<input type='password' name='Password'>";
        $submitAndEndForm = "<input type='submit' value='Update'></form>";
        echo ("
        $startForm
        <table>
        <tr><td>Name</td><td>$inputName</td></tr>
        <tr><td>Email</td><td>$inputEmail</td></tr>
        <tr><td>Password</td><td>$inputPassword</td></tr>
        </table>
      $submitAndEndForm"); }

    function processInput() {
        include("dbconnect.php");
        $un = 'bla';
        // $un = $_SESSION['username'];
        $nm = $_POST['Name'];
        $em = $_POST['Email'];
        $pw = $_POST['Password'];
        $pw = password_hash($pw, PASSWORD_DEFAULT);
        $sql = "UPDATE tbUser SET full_name = '" . $nm . "', email = '" . $em . "', password = '" . $pw . "' WHERE account_name = '" . $un . "'";
        if ($conn->query($sql))
          echo("User created successfully");
        else
          echo("Error: " . $conn->error); }

    if (!isset($_POST['Name']))
        getInput();
      else
        processInput();

?>
