<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thread's title</title>
    <link rel="stylesheet" href="../css/thread.css">
    <link rel="stylesheet" href="../css/menubar.css">
</head>
<body style="background-color: rgb(250, 243, 234);">
    <?php
        session_start();
        require_once('menubar.php');
        require_once('./functions/dbFunctions.php');

        $_SESSION['owner'] = false; // Initialises session variable (actual check is later)

        // Updates a comment's status if applicable
        if (isset($_POST['correctUnmark'])){
            updateCorrectComment($_POST['commentID'],0);
        }
        elseif(isset($_POST['correctMark'])){
            updateCorrectComment($_POST['commentID'],1);
        }
    ?>
    <div class="threadBg">
        <div class='upperPart'>
            <div class='image'>
                <img src='../img/cdpicture1.png' alt='default cover' width='480px' height='480px' >
            </div>
            <div class='contents'>";
                <?php

                    // Getting and displaying the thread information
                    $id  = $_GET['id'];
                    $result = getThread($id);
                    $output = "";
                    $author = "";
                    while ($row = $result->fetch_assoc()) {
                        $output .= "<div class='title'>
                                        <p><u>Title:</u> $row[title]</p>
                                        <p><u>Description:</u> $row[description]</p>
                                    </div>";
                        if ($author == "") {
                            $author =  $row['author'];
                        }
                    }
                    echo($output);

                    // Works out whether the user logged in (if there is one) is the owner of the current thread
                    if (isset($_SESSION['logged_in']) &&  $_SESSION['logged_in'] == true){
                        if (isset($_SESSION['username']) && $_SESSION['username'] == $author)
                            $_SESSION['owner'] = true;  // Updates the session variable accordingly
                    }
                ?>
                <div class='controls'>
                    <audio controls class='audio'>
                        <?php 
                            // Getting the file path for the audio
                            $path = getFilePath($id);
                            echo("<source src='" . $path ."'>");
                        ?>
                    </audio>
                    <input type='button' value='Like' class='btn'>
                </div>
            </div>
        </div>
        <hr class='hr1'>
        <div class='commentPart'>
            <?php
                // Getting and displaying the comments
                $result = getThreadComments($id);
                $output = "";
                while ($row = $result->fetch_assoc()) {
                    // Styles comments depeding on if they are marked as the correct answer or not
                    if ($row['confirm'] == true)
                        $output .= "<div class='publishComment correct'>";
                    else
                        $output .= "<div class='publishComment general'>";

                    $output .= "<div class='commentBody id'>
                                    <p><u>ID:</u></p>
                                    <p>$row[id]</p>
                                    <p><u>Likes:</u></p>
                                    <p>-</p>
                                </div>
                                <div class='commentBody main'>
                                    <p>$row[text]</p>
                                </div>
                                <div class='commentBody date'>
                                    <p><u>Created by:</u></p>
                                    <p>$row[author]</p>
                                    <p><u>Date created:</u></p>
                                    <p>$row[created_at]</p>
                                </div>";

                    // Allows the user to alter whether a comment is marked as a correct answer or not
                    if (isset($_SESSION['owner']) && $_SESSION['owner'] == true){   // Only if the user is logged in and is the owner of the thread
                        $output .= "<div class='commentBody'>
                                        <form method='POST'>
                                            <input type='hidden' name='commentID' value='$row[id]'>";
                        if ($row['confirm'] == true)
                            $output .= "<input type='submit' class='confirmButton' name='correctUnmark' value='Click to unmark as correct answer'>";
                        else
                            $output .= "<input type='submit' class='confirmButton' name='correctMark' value='Click to mark as correct answer'>";
                        $output .= "</form>
                                </div>
                            </div>";
                    }
                    else
                        $output .= "</div>";
                }
                echo($output);
            ?>

            <!-- New comment box -->
            <form method='POST' class='newCmtBtn'>
                <textarea type='text' name='comment' placeholder='please enter you comment here' maxlength='120' class='commentbar'></textarea>
                    <input type='submit' value='Send' class='btnSend'>
            </form>
        </div>
        <?php
            // New comment submission attempt
            if (isset($_POST['comment'])){
                if (isset($_SESSION['logged_in']) &&  $_SESSION['logged_in'] == true){
                    if ($_POST['comment'] != ""){
                        $date = date('Y-m-d H:i:s');
                        addNewComment($_POST['comment'],$date,$_SESSION['username'],$id);
                        echo("<script>window.location.replace('thread.php?id=" . $id . "');</script>");
                    }
                    else
                        echo("<script>alert('Please write something in your comment.');</script>");
                }
                else
                    echo("<script>alert('Please log in to post a comment.');</script>");
            }
        ?>
    </div>
</body>
</html>
