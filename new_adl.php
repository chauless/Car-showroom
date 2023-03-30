<?php

    // start session
    session_start();

    // create token
    $_SESSION['token'] = md5(uniqid(mt_rand(), true));

    // if user has theme in cookie, set it
    $themeClass = '';
    if (!empty($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark') {
        $themeClass = 'dark-theme';
    }

    // if user is not logged in, redirect to login page
    if (empty($_SESSION['user'])) {
        header('Location: new_ad.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>Nový inzerát - vroom.cz</title>

    <link rel="stylesheet" href="css/new_ad.css">
    <link rel="stylesheet" href="css/theme.css" id='theme'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;700;800&display=swap" rel="stylesheet">
    <meta charset="utf-8">
</head>

<!-- choose theme -->
<body class="<?php echo $themeClass; ?>">
<form action="php/signupl.php" method="post" enctype="multipart/form-data" id="form">
    <a href="index.php"><img src="img/logo_bg.png" alt="vroom.cz"></a>

    <!-- create token -->
    <input type="hidden" name="token" value="<?php echo isset($_SESSION['token']) ? $_SESSION['token'] : '' ?>">

    <h2>Auto</h2>
    <!-- input brand -->
    <label for="brand">Značka</label>
    <input type="text" id="brand" name="brand" placeholder="Audi" required minlength="2" maxlength="40"
    value="<?php if (isset($_SESSION['brand'])) echo htmlspecialchars($_SESSION['brand']); ?>">
    <?php if (isset($_SESSION['mBrand'])) { echo '<p class="msg"> ' . $_SESSION['mBrand'] . ' </p>'; } unset($_SESSION['mBrand']) ?>
    <div class="msg-js">Please enter valid brand</div>

    <!-- input model -->
    <label for="model">Model</label>
    <input type="text" id="model" name="model" placeholder="RS6" required minlength="2" maxlength="40"
    value="<?php if (isset($_SESSION['model'])) echo htmlspecialchars($_SESSION['model']); ?>">
    <?php if (isset($_SESSION['mModel'])) { echo '<p class="msg"> ' . $_SESSION['mModel'] . ' </p>'; } unset($_SESSION['mModel']) ?>
    <div class="msg-js">Please enter valid model</div>

    <h2>Сharakteristika</h2>
    <!-- input year -->
    <label for="year">Rok</label>
    <input type="number" id="year" name="year" placeholder="2022" required min="1900" max="2025"
           value="<?php if (isset($_SESSION['year'])) echo htmlspecialchars($_SESSION['year']); ?>">
    <?php if (isset($_SESSION['mYear'])) { echo '<p class="msg"> ' . $_SESSION['mYear'] . ' </p>'; } unset($_SESSION['mYear']) ?>
    <div class="msg-js">Please enter valid year </div>

    <!-- input milage -->
    <label for="milage">Najeto (km)</label>
    <input type="number" id="milage" name="milage" placeholder="7800" required min="0" max="999999"
           value="<?php if (isset($_SESSION['milage'])) echo htmlspecialchars($_SESSION['milage']); ?>">
    <?php if (isset($_SESSION['mMilage'])) { echo '<p class="msg"> ' . $_SESSION['mMilage'] . ' </p>'; } unset($_SESSION['mMilage']) ?>
    <div class="msg-js">Please enter valid milage</div>

    <!-- input color -->
    <label for="color">Barva</label>
    <input type="text" id="color" name="color" placeholder="Šedý" required minlength="2" maxlength="25"
    value="<?php if (isset($_SESSION['color'])) echo htmlspecialchars($_SESSION['color']); ?>">
    <?php if (isset($_SESSION['mColor'])) { echo '<p class="msg"> ' . $_SESSION['mColor'] . ' </p>'; } unset($_SESSION['mColor']) ?>
    <div class="msg-js">Please enter valid color</div>

    <!-- input power -->
    <label for="power">Výkon (hp)</label>
    <input type="number" id="power" name="power" placeholder="550" required min="50" max="2000"
           value="<?php if (isset($_SESSION['power'])) echo htmlspecialchars($_SESSION['power']); ?>">
    <?php if (isset($_SESSION['mPower'])) { echo '<p class="msg"> ' . $_SESSION['mPower'] . ' </p>'; } unset($_SESSION['mPower']) ?>
    <div class="msg-js">Please enter valid power</div>

    <!-- select type of gas -->
    <label for="palivo">Palivo</label>
    <select id="palivo" name="palivo" required>
        <option value="">Není zadáno</option>
        <option value="Benzin" <?php if (isset($_SESSION['palivo'])) {if ($_SESSION['palivo']=='Benzin') echo 'selected';} ?>>Benzín</option>
        <option value="Nafta" <?php if (isset($_SESSION['palivo'])) {if ($_SESSION['palivo']=='Nafta') echo 'selected';} ?>>Nafta</option>
        <option value="Elektro" <?php if (isset($_SESSION['palivo'])) {if ($_SESSION['palivo']=='Elektro') echo 'selected';} ?>>Elektro</option>
        <option value="Hybrid" <?php if (isset($_SESSION['palivo'])) {if ($_SESSION['palivo']=='Hybrid') echo 'selected';} ?>>Hybrid</option>
    </select>
    <?php if (isset($_SESSION['mPalivo'])) { echo '<p class="msg"> ' . $_SESSION['mPalivo'] . ' </p>'; } unset($_SESSION['mPalivo']) ?>
    <div class="msg-js">Please choose type of gas</div>

    <!-- select type of car -->
    <label for="karoserie">Karoserie</label>
    <select id="karoserie" name="karoserie" required>
        <option value="" >Není zadáno</option>
        <option value="SUV" <?php if (isset($_SESSION['karoserie'])) {if ($_SESSION['karoserie']=='SUV') echo 'selected';} ?>>SUV</option>
        <option value="Sedan" <?php if (isset($_SESSION['karoserie'])) {if ($_SESSION['karoserie']=='Sedan') echo 'selected';} ?>>Sedan</option>
        <option value="Kupe" <?php if (isset($_SESSION['karoserie'])) {if ($_SESSION['karoserie']=='Kupe') echo 'selected';} ?>>Kupé</option>
        <option value="Kabriolet" <?php if (isset($_SESSION['karoserie'])) {if ($_SESSION['karoserie']=='Kabriolet') echo 'selected';} ?>>Kabriolet</option>
    </select>
    <?php if (isset($_SESSION['mKaroserie'])) { echo '<p class="msg"> ' . $_SESSION['mKaroserie'] . ' </p>'; } unset($_SESSION['mKaroserie']) ?>
    <div class="msg-js">Please choose type of car</div>

    <!-- textarea for comments -->
    <h2>Popis</h2>
    <label for="comments">Popiště vaše auto</label>
    <textarea id="comments" name="desc" placeholder="Perfektní auto, nemlácené, nenamalované, jezdila babička." required minlength="10" maxlength="1950"
    ><?php if (isset($_SESSION['desc'])) echo htmlspecialchars($_SESSION['desc']); ?></textarea>
    <?php if (isset($_SESSION['mDesc'])) { echo '<p class="msg"> ' . $_SESSION['mDesc'] . ' </p>'; } unset($_SESSION['mDesc']) ?>
    <div class="msg-js">Please enter valid description</div>

    <!-- input price -->
    <h2>Cena</h2>
    <label for="price">Cena (v Kč)</label>
    <input type="number" placeholder="5500000" id="price" name="price" required min="1000" max="100000000"
           value="<?php if (isset($_SESSION['price'])) echo htmlspecialchars($_SESSION['price']); ?>">
    <?php if (isset($_SESSION['mPrice'])) { echo '<p class="msg"> ' . $_SESSION['mPrice'] . ' </p>'; } unset($_SESSION['mPrice']) ?>
    <div class="msg-js">Please enter valid price</div>

    <!-- send button -->
    <button type="submit" class="button" id="submit">Pokračovat</button>

    <?php
    // if there are any errors, display them
    if (isset($_SESSION['message'])) {
        echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
    }
    unset($_SESSION['message']);
    ?>
</form>
<!-- connect js -->
<script src="js/new_ad.js"></script>
</body>
</html>