<?php
    // if someone tries to access this file directly, redirect them to the 404 page
//    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
//        header("Location: ../profile.php");
//    }

    // require the database connection
    session_start();
    require 'connect.php';

    // function to clear input data
    function clearData($data) {
        $data = trim($data);
//        $data = stripslashes($data);
//        $data = strip_tags($data);
//        $data = str_replace(['\'', '\"', '"', "'", '<', '>'], ' ', $data);
//        $data = htmlspecialchars($data);
        return $data;
    }

    // check if user delete input fields via inspect element and delete input fields in html
    if (!isset($_POST['brand']) || !isset($_POST['model']) || !isset($_POST['year']) || !isset($_POST['color']) || !isset($_POST['milage']) || !isset($_POST['power']) || !isset($_POST['palivo']) || !isset($_POST['karoserie']) || !isset($_POST['desc']) || !isset($_POST['price'])) {
        $_SESSION['message'] = 'Jste si jisti, že jste vyplnil všechny pole?';
        header('Location: ../edit_ad.php');
        exit();
    }

    // clear input data
    $brand = clearData($_POST['brand']);
    $model = clearData($_POST['model']);
    $year = clearData($_POST['year']);
    $milage = clearData($_POST['milage']);
    $color = clearData($_POST['color']);
    $power = clearData($_POST['power']);
    $karoserie = clearData($_POST['karoserie']);
    $palivo = clearData($_POST['palivo']);
    $desc = clearData($_POST['desc']);
    $price = clearData($_POST['price']);

    // flag to check if there are any errors
    $flag = true;

    // validation of input data
    // if any inputs are wrong, flag will be set to false and user will be redirected to signup page with his inputs saved
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (mb_strlen($brand) < 3 || empty($brand) || mb_strlen($brand) > 40) {
            $_SESSION['mBrand'] = 'Brand must contain from 3 to 40 characters';
            $flag = false;
        }
        if (mb_strlen($model) < 3 || empty($model) || mb_strlen($model) > 40) {
            $_SESSION['mModel'] = 'Model must contain from 3 to 40 characters';
            $flag = false;
        }
        if ($year < 1900 || $year > 2023) {
            $_SESSION['mYear'] = 'Year must be between 1900 and 2023';
            $flag = false;
        }
        if (!mb_strlen($year) == 4 || empty($year)) {
            $_SESSION['mYear'] = 'Year must contain 4 characters';
            $flag = false;
        }
        if (empty($milage)) {
            $_SESSION['mMilage'] = 'Milage must be filled';
            $flag = false;
        }
        if (!filter_var($milage, FILTER_VALIDATE_INT)) {
            $_SESSION['mMilage'] = 'Milage must be a number';
            $flag = false;
        }
        if ($milage < 0 || $milage > 1000000) {
            $_SESSION['mMilage'] = 'Milage must be between 0 and 999999';
            $flag = false;
        }
        if (empty($color)) {
            $_SESSION['mColor'] = 'Color must be filled';
            $flag = false;
        }
        if ($power < 50 || $power > 2000) {
            $_SESSION['mPower'] = 'Power must be between 50 and 2000';
            $flag = false;
        }
        if (!filter_var($power, FILTER_VALIDATE_INT)) {
            $_SESSION['mPower'] = 'Power must be a number';
            $flag = false;
        }
        if (empty($power)) {
            $_SESSION['mPower'] = 'Power must be filled';
            $flag = false;
        }

        if (!in_array($karoserie, ['Sedan', 'Kupe', 'SUV', 'Kabriolet'])) {
            $_SESSION['mKaroserie'] = 'Karoserie must be filled';
            $flag = false;
        }

        if (!in_array($palivo, ['Benzin', 'Nafta', 'Elektro', 'Hybrid'])) {
            $_SESSION['mPalivo'] = 'Palivo must be filled';
            $flag = false;
        }

        if (mb_strlen($desc) < 10 || mb_strlen($desc) > 1950) {
            $_SESSION['mDesc'] = 'Description must from 10 to 1950 characters';
            $flag = false;
        }
        if (empty($desc)) {
            $_SESSION['mDesc'] = 'Description must be filled';
            $flag = false;
        }
        if (!filter_var($price, FILTER_VALIDATE_INT)) {
            $_SESSION['mPrice'] = 'Price must be a number';
            $flag = false;
        }
        if ($price < 999 || $price > 100000000) {
            $_SESSION['mPrice'] = 'Price must be between 1000 and 100000000';
            $flag = false;
        }
        if (empty($price)) {
            $_SESSION['mPrice'] = 'Price must be filled';
            $flag = false;
        }

        // if there are errors, redirect to new ad
        if ($flag == false) {
            $_SESSION['message'] = 'Prosím vyplňte všechna pole!';
            header('Location: ../edit_ad.php?id=' . $_SESSION['id']);
            exit();
        }
    }

    global $db;

    // if everything is ok, insert new user into database
    if ($flag == true) {;
        // update car in database using prepared statement
        $updateCar = $db->prepare("UPDATE cars SET brand = :brand, model = :model, year = :year, milage = :milage, color = :color, price = :price, power = :power, palivo = :palivo, karoserie = :karoserie WHERE id = :id");
        $updateCar->execute([
            ':brand' => $brand,
            ':model' => $model,
            ':year' => $year,
            'milage' => $milage,
            'color' => $color,
            'price' => $price,
            'power' => $power,
            'palivo' => $palivo,
            'karoserie' => $karoserie,
            ':id' => $_SESSION['id']
        ]);

        // update description in database using prepared statement
        $updateDesc = $db->prepare("UPDATE cars SET `desc`  = :desc WHERE id = :id");
        $updateDesc->execute([
            ':desc' => $desc,
            ':id' => $_SESSION['id']
        ]);

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

        $_SESSION['milage'] = $milage;
        // redirect to photo upload page
        header('Location: ../photo_upload.php');
    }








