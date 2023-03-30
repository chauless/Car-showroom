<?php
    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    }

    // start the session
    session_start();

    // if user have saved theme, apply it
    $themeClass = '';
    if (!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        $themeClass = 'dark-theme';
    }
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>vroom.cz</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/theme.css" id='theme'>
    <meta charset="utf-8">
</head>

<body class="<?php echo $themeClass; ?>">
<header class="header">
    <!-- header with logo and login/register buttons -->
    <a href="index.php"><img src="img/logo_bg.png" class="logo" alt="vroom.cz"></a>
    <div class="auth">
        <a href="login.php" class="login">
            <?php
                // if user is not logged in, show login button
                if(!isset($_SESSION['user'])):
                    echo 'Přihlášení';
                else:
                // if logged in, show his ads
                    echo 'Moje inzeráty';
                endif;
            ?>
        </a>
        <a href="<?php if(!isset($_SESSION['user'])) { ?>new_ad.php<?php } else { ?> php/logout.php <?php } ?>" class="reg">
            <?php
                // if user is not logged in, show register button
                if(!isset($_SESSION['user'])):
                    echo 'Nový inzerát';
                else:
                // if logged in, show logout button
                    echo 'Logout';
                endif;
            ?>
        </a>
    </div>
</header>

<!-- navigation bar -->
<nav class="nav">
    <a href="cars.php?page=1" class="sedan">All</a>
    <a href="cars.php?page=1&karoserie=sedan" <?php
        // if user is on sedan page, highlight it
        if (isset($_GET['karoserie']) && $_GET['karoserie'] == 'sedan') {
            echo 'class="sedan used"';
        } else {
            echo 'class="sedan"';
        }
    ?>>Sedan</a>
    <a href="cars.php?page=1&karoserie=kupe" <?php
    // if user is on kupe page, highlight it
    if (isset($_GET['karoserie']) && $_GET['karoserie'] == 'kupe') {
        echo 'class="kupe used"';
    } else {
        echo 'class="kupe"';
    }
    ?>>Kupé</a>
    <a href="cars.php?page=1&karoserie=kabriolet" <?php
    // if user is on kabriolet page, highlight it
    if (isset($_GET['karoserie']) && $_GET['karoserie'] == 'kabriolet') {
        echo 'class="kabriolet used"';
    } else {
        echo 'class="kabriolet"';
    }
    ?>">Kabriolet</a>
    <a href="cars.php?page=1&karoserie=SUV" <?php
    // if user is on SUV page, highlight it
    if (isset($_GET['karoserie']) && $_GET['karoserie'] == 'SUV') {
        echo 'class="suv used"';
    } else {
        echo 'class="suv"';
    }
    ?>>SUV</a>
    <img src="img/moon.png" alt="theme" id="switch-theme" class="icon">
    <script src="js/theme.js"></script>
</nav>