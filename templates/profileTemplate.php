<?php

    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    }

    // get cars by user email
    function getAdsByUserEmail($email)
    {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE email = '$email'");
        return $query;
    }

    // if user is logged in show his ads
    if (isset($_SESSION['user'])) {
            $userEmail = $_SESSION['user']['email'];
            $ads = getAdsByUserEmail($userEmail);
            // if user doesn't have ads don't show anything
            if ($ads == false) {
                echo "You don't have any ads yet.";
            }
        }

    foreach ($ads as $ad): ?>
        <!-- template for ad -->
        <div class="ad">
            <a href="ad.php?id=<?php echo $ad['id'] ?>"><img src="<?php echo $ad['photo'] ?>" class="photo" alt=""></a>
            <div class="description">
                <a href="ad.php?id=<?php echo $ad['id'] ?>" class="name"><?php echo htmlspecialchars($ad['brand']) . ' ' . htmlspecialchars($ad['model']) ?></a>
                <p class="price"><?php echo htmlspecialchars($ad['price']) ?> CZK</p>
                <p class="year"><?php echo htmlspecialchars($ad['year']) ?></p>
                <p class="milage"><?php echo htmlspecialchars($ad['milage']) ?> km</p>
            </div>
            <div class="additionalInfo">
                <p><?php echo htmlspecialchars($ad['power']) ?> hp</p>
                <p><?php echo htmlspecialchars($ad['karoserie']) ?></p>
                <p class="color"><?php echo htmlspecialchars($ad['color']) ?></p>
            <br>
            <?php
                // button to delete this ad from database
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['user']['email'] == $ad['email']) {
                        echo '<a href="php/deleteAd.php?id=' . $ad['id'] . '" class="delete">Smazát inzerát</a>';
                    }
                }
            ?> <br> <?php
                // button to edit this ad
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['user']['email'] == $ad['email']) {
                        echo '<a href="edit_ad.php?id=' . $ad['id'] . '" class="delete">Upravit inzerát</a>';
                    }
                }
                // add id to array of ads
                $adIds[] = $ad['id'];
                $_SESSION['adIds'] = $adIds;
                ?>
            </div>
        </div>

<?php endforeach; ?>
