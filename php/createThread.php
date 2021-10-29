<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create new thread</title>
        <link rel="stylesheet" href="../css/createThread.css">
        <link rel="stylesheet" href="../css/menubar.css">
    </head>
    <body>
        <?php
            session_start();
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (isset($_POST['create'])){
                require 'createThread-submit.php';
            }
            }
            require_once('menubar.php');
        ?>
        <div class="createHeader">
            <h1>Create new thread</h1>
        </div>

        <div class="createThreadWrapper">
            <form action="createThread.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="form">
                    <div class="item" data-error-title-empty="Cannot be empty, try again!" data-error-title-exists="Title already exists, try another!">
                        <input type="text" class="input" placeholder="Title (length: 1-100)" name="title" maxlength="100">
                    </div>
                    <div class="item" data-error-des-empty="Cannot be empty, try again!">
                        <textarea type="text" class="description" name="description" placeholder="Description (length: 1-200)" maxlength="200"></textarea>
                    </div>
                </div>
                <div class="upload" data-error-file-size="Max size is 10mb, try again!" data-error-file-type="Only audio files allowed (mp3 etc.) try agan!" data-error-file-empty="No file found, please try again!">
                    <input type="file" name="file">
                </div>
                    <button name="create" class="button">Create</button>
            </form>
            <script type="text/javascript">
                document.querySelectorAll(".createThreadWrapper .form .item[data-error-title-empty] input").forEach(intEl => {inpEl.addEventListener("input", () => inpEl.parentElement.removeAttribute("data-error-title-empty"));});
                document.querySelectorAll(".createThreadWrapper .form .item[data-error-title-exists] input").forEach(intEl => {inpEl.addEventListener("input", () => inpEl.parentElement.removeAttribute("data-error-title-exists"));});
                document.querySelectorAll(".createThreadWrapper .form .item[data-error-des-empty] input").forEach(intEl => {inpEl.addEventListener("input", () => inpEl.parentElement.removeAttribute("data-error-des-empty"));});
                document.querySelectorAll(".createThreadWrapper .upload[data-error-file-size] input").forEach(intEl => {inpEl.addEventListener("input", () => inpEl.parentElement.removeAttribute("data-error-file-size"));});
                document.querySelectorAll(".createThreadWrapper .upload[data-error-file-type] input").forEach(intEl => {inpEl.addEventListener("input", () => inpEl.parentElement.removeAttribute("data-error-file-type"));});
                document.querySelectorAll(".createThreadWrapper .upload[data-error-file-empty] input").forEach(intEl => {inpEl.addEventListener("input", () => inpEl.parentElement.removeAttribute("data-error-file-empty"));});
            </script>
        </div>
    </body>
</html>