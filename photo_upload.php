<?php

    // start session
    session_start();
    require_once 'php/connect.php';

    // if user is not logged in, redirect to new ad page
    if (!isset($_SESSION['milage'])) {
        header('Location: new_ad.php');
    }

    // if user has theme in cookie, set it
    $themeClass = '';
    if (!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        $themeClass = 'dark-theme';
    }
?>

<!DOCTYPE html>
<html lang="cs">

<!-- choose the theme -->
<body class="<?php echo $themeClass; ?>">
<head>
    <title>Photo upload - vroom.cz</title>

    <link rel="stylesheet" href="css/new_ad.css">
    <link rel="stylesheet" href="css/theme.css" id='theme'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;700;800&display=swap" rel="stylesheet">
    <meta charset="utf-8">
</head>

<form action="php/upload.php" method="post" enctype="multipart/form-data" id="form1">
    <!-- logo with link to home page -->
    <a href="index.php?nophoto=true"><img src="img/logo_bg.png" alt="vroom.cz"></a>

    <!-- input photo -->
    <h2>Fotografie</h2>
    <input type="file" name="photo" id="photo" required accept="image/*">
    <div class="msg-js">Please choose valid photo (.png / .jpg / .webp)</div>

    <!-- button for send the form -->
    <button type="submit" class="button" id="submit"">Přidat inzerát</button>

    <?php
    // if there are any errors, display them
    if (isset($_SESSION['message1'])) {
        echo '<p class="msg"> ' . $_SESSION['message1'] . ' </p>';
    }
    // unset session message
    unset($_SESSION['message1']);
    ?>

    <p class="register">Už máte účet? <a href="login.php">Přihláste se</a></p>
</form>
<!-- connect js -->
<script src="js/upload_photo.js"></script>
</body>
</html>