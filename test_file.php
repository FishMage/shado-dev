<?php

    session_start();
    session_destroy();

    if (!empty($_SESSION)) {
        echo "Session here!";
        print_r($_SESSION);
    } else {
        echo "No session.";
    }
