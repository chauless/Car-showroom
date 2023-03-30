<?php

    // start session
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: profile.php');
    }

    // create token
    $_SESSION['token'] = md5(uniqid(mt_rand(), true));

    // if user has theme in cookie, set it
    $themeClass = '';
    if (!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        $themeClass = 'dark-theme';
    }
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>Login - vroom.cz</title>

    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/theme.css" id='theme'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;700;800&display=swap" rel="stylesheet">
    <meta charset="utf-8">
</head>

<!-- choose theme -->
<body class="<?php echo $themeClass; ?>">
    <form action="php/signin.php" method="post" id="form">

        <!-- logo with link to home page -->
        <a href="index.php"><img src="img/logo_bg.png" alt="vroom.cz"></a>

        <input type="hidden" name="token" value="<?php echo isset($_SESSION['token']) ? $_SESSION['token'] : '' ?>">

        <h2>Přihlášení</h2>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" value="<?php if (isset($_SESSION['email'])) echo htmlspecialchars($_SESSION['email']); ?>" required pattern="^([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\.[a-zA-Z]{2,6}$">
        <div class="msg-js">Please enter your email</div>

        <label for="password">Heslo</label>
        <input type="password" id="password" name="password" placeholder="Password" required minlength="4">
        <div class="msg-js">Please enter your password</div>

        <button type="submit" class="button" id="button">Přihlásit se</button>

        <?php
            // if there are any errors, show them
            if (isset($_SESSION['message2'])) {
                echo '<p class="msg"> ' . $_SESSION['message2'] . ' </p>';
            }
            unset($_SESSION['message2']);
        ?>

        <p class="register">Nemáte účet? <a href="new_ad.php">Zaregistrujte se</a></p>
    </form>
    <!-- connect js -->
    <script src="js/login.js"></script>
</body>
</html>