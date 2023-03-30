<?php

    // logout the user
    session_start();
    unset($_SESSION['user']);

    // destroy the session and return to index.php
    session_destroy();
    header('Location: ../index.php');