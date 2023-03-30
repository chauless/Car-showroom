<?php
    // if someone tries to access this file directly, redirect them to the 404 page
//    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
//        header("Location: ../profile.php");
//    }

    // require the database connection
    session_start();
    require 'connect.php';

    if (!isset($_SESSION['user'])) {
        header("Location: 404.php");
        exit();
    }

    $check = checkCar($_GET['id'], $_SESSION['user']['email']);
    if (!$check) {
        header("Location: index.php");
        exit();
    }

    // delete car from database using id from GET and prevent SQL injection
    if (htmlspecialchars(isset($_GET['id']))) {
        global $db;
        $id = htmlspecialchars($_GET['id']);
        $query = $db->prepare("DELETE FROM cars WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        header("Location: ../profile.php");
        ?><a href="../profile.php">Click to return to profile page</a><?php
        return $query;
    }


