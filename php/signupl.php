<?php
    // if someone tries to access this file directly, redirect them to the 404 page
//    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
//        header("Location: 404.php");
//    }

    // start session
    session_start();
    require_once 'connect.php';

    // if user has theme in cookie, set it
    $themeClass = '';
    if (!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        $themeClass = 'dark-theme';
    }

    // check the token
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token']) {
        // return 404 http status code
        header("Location: ../profile.php?error=invalidtoken");
        exit;
    }

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
        header('Location: ../new_adl.php');
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

    // save milage to session to check if user car upload photo in next step
    $_SESSION['model'] = $model;
    $_SESSION['brand'] = $brand;
    $_SESSION['year'] = $year;
    $_SESSION['color'] = $color;
    $_SESSION['power'] = $power;
    $_SESSION['karoserie'] = $karoserie;
    $_SESSION['palivo'] = $palivo;
    $_SESSION['desc'] = $desc;
    $_SESSION['price'] = $price;
    $_SESSION['milage'] = $milage;

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
        if (empty($color) || mb_strlen($color) > 25) {
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
            header('Location: ../new_adl.php');
            exit();
        }
    }

    global $db;
    // check ad and prevent SQL injection
    $check_ad = $db->prepare("SELECT * FROM `cars` WHERE `brand` = :brand AND `model` = :model AND `year` = :year AND `milage` = :milage AND `color` = :color");
    $check_ad->execute([
        ':brand' => $brand,
        ':model' => $model,
        ':year' => $year,
        ':milage' => $milage,
        ':color' => $color
    ]);
    $ad = $check_ad->fetch(PDO::FETCH_ASSOC);

    // if this ad already exists, redirect to new ad and show error message
    if ($ad > 0) {
        // if exists, unset data
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
        $_SESSION['message'] = 'Tento inzerát již existuje!';
        header('Location: ../new_adl.php');
        exit();
    }

    // if everything is ok, insert new user into database
    if ($flag == true) {
        $email = $_SESSION['email'];

        // insert new ad into database
        $insert_car = $db->prepare("INSERT INTO `cars` (`id`, `email`, `brand`, `model`, `year`, `milage`, `color`, `power`, `karoserie`, `palivo`, `price`, `desc`) VALUES (NULL, :email, :brand, :model, :year, :milage, :color, :power, :karoserie, :palivo, :price, :desc)");
        $insert_car->execute([
            ':email' => $email,
            ':brand' => $brand,
            ':model' => $model,
            ':year' => $year,
            ':milage' => $milage,
            ':color' => $color,
            ':power' => $power,
            ':karoserie' => $karoserie,
            ':palivo' => $palivo,
            ':price' => $price,
            ':desc' => $desc
        ]);

        // save this ad id into session
        $get_id = $db->prepare("SELECT `id` FROM `cars` WHERE `brand` = :brand AND `model` = :model AND `year` = :year AND `milage` = :milage AND `color` = :color");
        $get_id->execute([
            ':brand' => $brand,
            ':model' => $model,
            ':year' => $year,
            ':milage' => $milage,
            ':color' => $color
        ]);
        $id = $get_id->fetch(PDO::FETCH_ASSOC);
        if ($id > 0) {
            $_SESSION['id'] = $id['id'];
        } else {
            $_SESSION['message'] = 'Něco se pokazilo, zkuste to prosím znovu!';
            header('Location: ../new_adl.php');
            exit();
        }

        // unset all data to prevent resending and using it in next ad
        unset($_SESSION['brand']);
        unset($_SESSION['model']);
        unset($_SESSION['year']);
        unset($_SESSION['color']);
        unset($_SESSION['power']);
        unset($_SESSION['karoserie']);
        unset($_SESSION['palivo']);
        unset($_SESSION['desc']);
        unset($_SESSION['price']);

        // redirect to photo upload page
        header('Location: ../photo_upload.php');
    }








