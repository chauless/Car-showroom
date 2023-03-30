<?php
    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    }

    // get random ads from database
    $ads = getCarRandom();

    // go through each ad and display them
    foreach ($ads as $ad): ?>

    <div class="ad">
        <a href="ad.php?id=<?php echo $ad['id'] ?>"><img src="<?php echo $ad['photo'] ?>" alt="photo" class="photo"></a>
        <a class="name" href="ad.php?id=<?php echo $ad['id'] ?>"><?php echo htmlspecialchars($ad['brand']) . ' ' . htmlspecialchars($ad['model']) ?></a> <br>
        <p class="price"><?php echo htmlspecialchars($ad['price']) ?> CZK</p>
    </div>

    <?php endforeach; ?>