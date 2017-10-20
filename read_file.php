<?php
    session_start();

    $file = fopen($_SESSION['session_dir'] . $_GET['filename'], "r") or die("Cannot open " . $_SESSION['session_dir'] . $_GET['filename'] . " Please return to check and update your settings.");
    while(($line = fgets($file)) !== false){
        echo $line;
    }
    fclose($file);

    // $dir = sys_get_temp_dir() . "/" . uniqid();
    // echo $dir;
    // mkdir($dir);
    // phpinfo();
