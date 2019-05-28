<?php

include("main.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Hackaton</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="container mt-5">
            <form method="post">
                <h1 class="display-4 mb-3 text-center">Trova parole frequenti</h1>

                <div class="form-group position-relative">
                    <label class="text-muted h4">Scrivi il tuo testo qui:</label>
                    <input type="text" class="form-control" name="text">
                </div>

                <button class="btn btn-info btn-lg text-uppercase">Inizia</button>
            </form>

            <div class="border rounded p-3 mt-3">
                
                <?php if(isset($_POST['text'])){
                        $page = $_POST['text'];
                        
                        $content = searchByTag("title", $page)." ";
                        $content .= searchByTag("p", $page);
                        
                        echo(findwords(htmlspecialchars_decode($content)));
                    }
                    
                ?>

            </div>
        </div>

    <!-- Latest compiled and minified JavaScript -->

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    </body>
</html>