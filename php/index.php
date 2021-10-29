<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LyricMe</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/menubar.css">
</head>
<body class="mainBg">
    <!-- Begins session -->
    <?php
        session_start();
        // Sets default values session variables
        if (!isset($_SESSION['sort']))
            $_SESSION['sort'] = "ASC";      // Sort DEFAULT = ascending (Oldest first)
        if (!isset($_SESSION['searchString']))
            $_SESSION['searchString'] = "";     // search DEFAULT = "" (empty)
        require_once('menubar.php');
    ?>
    <div class="mainHeader">
            LyricMe            
    </div>
        <?php
            $output = "<div class ='search-wrapper'>
                        <form method='POST'>
                        <input type='submit' class='clearButton' name='clear' value='View All'>
                        <input type='text' class='searchBar' name='searchPhrase' placeholder='Please enter your search phrase' >
                        <input type='submit' class='searchButton' name='search' value='Search'>
                        </form>
                      </div>";
            echo($output);
        ?>
    </div>
    <hr class="hr1">
    <div class="main-contents">
        <div class="threadSort">
            <form method="POST">
                <p>Sort By:</p>
                <hr>
                <select class = "sortDropdown" name="sort">
                    <option value="default" selected>Please select an option</option>
                    <option value="Oldest First">Oldest First</option>
                    <option value="Newest First">Newest First</option>
                </select>
                <hr>
                <input type="submit" class="sortButton" value="Sort">
            </form>
        </div>
        <div class="threadBg">
        <?php
            // Checking which order to sort the threads
            if (isset($_POST['sort'])){
                if ($_POST['sort'] == "Oldest First")
                    $_SESSION['sort'] = "ASC";  // ASC (OLDEST FIRST) 
                elseif ($_POST['sort'] == "Newest First")
                    $_SESSION['sort'] = "DESC"; // DESC (NEWEST FIRST)
            }

            // Checking for search inputs
            if (isset($_POST['search']))
                $_SESSION['searchString'] = $_POST['searchPhrase'];
            elseif (isset($_POST['clear']))
                $_SESSION['searchString'] = "";

            // Searches for results from the database
            require_once('./functions/dbFunctions.php');
            $result = getThreads($_SESSION['sort'],$_SESSION['searchString']);

            // Outputs the data to the screen
            $output = "";
            while ($row = $result->fetch_assoc()) {
              // wrapping each output in a div
                $output .=  "<div class='threadItem'>
                                <a href='thread.php?id=$row[id]'>
                                    <div class='threadBody'>
                                        <div class='threadBody id'>
                                            <p><u>ID:</u></p>
                                            <p>$row[id]</p>
                                            <p><u>Likes:</u></p>
                                            <p>-</p>
                                        </div>
                                        <div class='threadBody main'>
                                            <p>$row[title]</p>
                                            <p>$row[description]</p>
                                        </div>
                                        <div class='threadBody date'>
                                            <p><u>Created by:</u></p>
                                            <p>$row[author]</p>
                                            <p><u>Date created:</u></p>
                                            <p>$row[created_at]</p>
                                        </div>
                                    </div>
                                </a>
                              </div>
                            <hr class='threadHr'>";
            }
            echo($output);
        ?>   
        </div>
        <div class="createThread">
            <?php
                if (isset($_SESSION['logged_in'])) {
                    if ($_SESSION['logged_in'] == true) {
                        echo '<a href="createThread.php" class="wrapper">
                                <button>Create new thread</button>
                            </a>';
                    }
                }
            ?>
        </div>
    </div>

</body>
</html>