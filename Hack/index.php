<?php

include("main.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Hackaton</title>
        <link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header class="hidden-sm hidden-xs shadow-sm"></header>

        <div class="container my-5">
            <form method="post">
                <h1 class="display-4 mb-3 text-center">Trova parole frequenti</h1>

                <div class="form-group position-relative">
                    <label class="text-muted h4">Scrivi il tuo url qui:</label>
                    <input type="text" class="form-control" name="text">
                </div>

                <button class="btn btn-info btn-lg text-uppercase">Inizia</button>
            </form>
                
                <?php if(isset($_POST['text'])){
                        $page = $_POST['text'];
                        
                        $content = searchByTag("title", $page)." ";
                        $content .= searchByTag("p", $page);
                        
                        findwords(htmlspecialchars_decode($content));
                    }
                    
                ?>
                
        </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    </body>
</html>