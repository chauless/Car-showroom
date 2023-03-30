<?php
    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    }

    // start session
    session_start();
    require_once 'connect.php';

    // if user is not logged in, redirect to new ad page
    if (!isset($_SESSION['milage'])) {
        header('Location: new_ad.php');
    }

    // check if the file is image
    $types = array('image/webp', 'image/png', 'image/jpeg', 'image/pjpeg', 'image/web');
    if (!in_array($_FILES['photo']['type'], $types)){
        header('Location: ../photo_upload.php');
        $_SESSION['message1'] = 'Tento soubor není obrázek! Obrázek by měl být typu .webp, .png, nebo .jpeg';
        exit();
    }

    // create a random name for the image
    $photo = $_FILES['photo']['name'];
    $path = 'uploads/' . time() . $_FILES['photo']['name'];
    // move file to local storage
    move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $path);

    // update an image location into the database
    global $db;
    $update_image = $db->prepare("UPDATE cars SET photo = :photo WHERE id = :id");
    $update_image->execute(array(
        ':photo' => $path,
        ':id' => $_SESSION['id']
    ));

    // redirect to the login page
    $_SESSION['message2'] = "Registrace byla úspěšná";
    // unset milage to prevent going to this page after adding new car
    unset($_SESSION['brand']);
    unset($_SESSION['model']);
    unset($_SESSION['year']);
    unset($_SESSION['milage']);
    unset($_SESSION['color']);
    unset($_SESSION['power']);
    unset($_SESSION['karoserie']);
    unset($_SESSION['palivo']);
    unset($_SESSION['desc']);
    unset($_SESSION['price']);
    header('Location: ../login.php');



