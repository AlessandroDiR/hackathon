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
        <link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header class="hidden-sm hidden-xs shadow-sm"></header>

        <div class="position-relative">
			<div class="bars" data-toggle="collapse" data-target="#collapse">
				<div class="bar"></div>
			</div>

            <div class="collapse rounded ml-3 col-8 col-md-2 p-0 mt-4 position-absolute" id="collapse">
                <nav class="nav flex-column">
                    <?php echo getDataFromDB(); ?>
                </nav>
            </div>
        </div>

        <div class="container my-5 main">
            <form method="post">
                <h1 class="display-4 mb-3 text-center">Trova parole frequenti</h1>

                <div class="form-group">
                    <label class="text-muted h4">Scrivi il tuo url qui:</label>
                    <input type="text" class="form-control" name="text">
                </div>

                <div class="form-group">
                    <label class="text-muted h4">Lingua:</label>
                    <select class="form-control custom-select pointer" name="lang">
                        <option value="it" <?php if(isset($_POST['lang']) && $_POST['lang'] == "it") echo "selected"; ?>>Italiano</option>
                        <option value="en" <?php if(isset($_POST['lang']) && $_POST['lang'] == "en") echo "selected"; ?>>English</option>
                    </select>
                </div>

                <button class="btn btn-info btn-lg text-uppercase">Inizia</button>
            </form>
                
                <?php 
                    
                    if(isset($_POST['text']) && isset($_POST['lang'])){
                        $page = $_POST['text'];
                        
                        $content = getPageContent($page);
                        
                        echo findwords(htmlspecialchars_decode($content), $page);
                    }
                ?>
                
            <div id="page-content" class="mt-3 text-justify"></div>
        </div>

        <footer class="footer font-small mt-auto bg-info pt-4">

            <div class="row px-5">

                <div class="col-6">
                    <h5 class="text-uppercase">Cerca Parole Project</h5>
                    <p>The Cerca Parole project is an advanced program that allows you to search the most used words inside a web page.</p>
                    <p>This tool is very useful if you want to be self-aware of your own repititions.</p>
                </div>

                <div class="col-6 text-right">
                    <h5 class="text-uppercase">Special thanks to:</h5>

                    <ul class="list-unstyled">
                        <li>
                            <p>Leonardo Grandolfo</p>
                        </li>
                        <li>
                            <p>Alessandro Di Roma</p>
                        </li>
                        <li>
                            <p >Enore Lasi</p>
                        </li>
                        <li>
                            <p>Francesco Carnevali</p>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="text-center pb-1">
                ©2019 Copyright: <a href="https://www.fitstic.it/" class="text-white"> Fitstic.it</a>
            </div>

        </footer>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="js/script.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>
