<?php

    // start session and connect to DB
    session_start();
    require 'php/connect.php';

    // if user is not logged in, redirect to login page
    if(!isset($_SESSION['user'])){
        header("Location: login.php");
    }

    // if user have theme in cookie, set it
    $themeClass = '';
    if (!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        $themeClass = 'dark-theme';
    }

    ?>


<!DOCTYPE html>
<html lang="cs">

	<head>
		<title>vroom.cz</title>

		<link rel="stylesheet" href="css/cars.css">
        <link rel="stylesheet" href="css/theme.css" id='theme'>
        <link rel="stylesheet" href="css/header.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;700;800&display=swap" rel="stylesheet">
		<meta charset="utf-8">
	</head>

    <!-- set the theme -->
    <body class="<?php echo $themeClass; ?>">
		<header class="header">
			<a href="index.php"><img src="img/logo_bg.png" class="logo" alt="vroom.cz"></a>
			<div class="auth">
				<a href="profile.php" class="login">Moje inzeráty</a>
				<a href="php/logout.php" class="reg">Logout</a>
			</div>
		</header>

        <!-- navigation bar -->
		<nav class="nav">
            <a href="cars.php?page=1" class="sedan">All</a>
			<a href="cars.php?page=1&karoserie=sedan" class="sedan">Sedan</a>
			<a href="cars.php?page=1&karoserie=kupe" class="kupe">Kupé</a>
			<a href="cars.php?page=1&karoserie=kabriolet" class="kabriolet">Kabriolet</a>
			<a href="cars.php?page=1&karoserie=SUV" class="suv">SUV</a>
            <img src="img/moon.png" alt="theme" id="switch-theme" class="icon">
            <script src="js/theme.js"></script>
		</nav>

		<main>
            <!-- button to add a new car -->
            <a class="new_ad" href="new_adl.php" class="new_ad">Nový inzerát</a>

            <!-- get all user ads from DB -->
			<div class="ad">
                <?php require 'templates/profileTemplate.php'; ?>
			</div>
		</main>
	</body>
</html>