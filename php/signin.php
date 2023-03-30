<?php
    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    }
    
    // start session
    session_start();
    require_once 'connect.php';

    // check the token
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token']) {
        // return 404 http status code
        header("Location: 404.php");
        exit;
    }

    // make new variable for email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check if user exists and prevent SQL injection
    global $db;
    $check_user = $db->prepare("SELECT * FROM `users2` WHERE `email` = :email");
    $check_user->bindParam(':email', $email);
    $check_user->execute();
    $user = $check_user->fetch(PDO::FETCH_ASSOC);

    // check if user exists in DB
    if ($user > 0) {
        // if exists, check if password is correct
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['user'] = [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
            ];
            
            // if password is correct, redirect to profile page
            header('Location: ../profile.php');
        } else {
            // if password is wrong, redirect to login.php and show error message
            $_SESSION['email'] = $email;
            $_SESSION['message2'] = 'Nesprávné heslo!';
            header('Location: ../login.php');
        }
    } else {
        // if user doesn't exist, redirect to login.php and show error message
        $_SESSION['message2'] = 'Takový e-mail není zaregistrován!';
        header('Location: ../login.php');
    }