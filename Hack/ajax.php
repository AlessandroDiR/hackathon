<?php

include('main.php');

if(isset($_POST['id']))
    echo getContent(addslashes($_POST['id']));