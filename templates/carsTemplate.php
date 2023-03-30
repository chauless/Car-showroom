<?php
    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    }

    // set the limit of cars per page and set the offset to the page number
    $limit = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // if page is less than 1 or is not a number, redirect to the 1 page
    if ($page < 1 || !is_numeric($page)) {
        $page = 1;
    }

    // set the offset
    $offset = ($page - 1) * $limit;


    // get cars from DB with offset
    $ads = getCarOffset($offset);
    
    // sort by karoserie
    $karoseries = array('kupe', 'sedan', 'kabriolet', 'SUV');
    if (isset($_GET['karoserie'])) {
        in_array($_GET['karoserie'], $karoseries);
        // if karoserie is invalid, print error
        if (!in_array($_GET['karoserie'], $karoseries)) {
            echo "Invalid karoserie";
            exit();
        }
        $ads = getCarKaroserie($offset, $_GET['karoserie']);
    }

    // sort by price
    if (isset($_GET['price'])) {
        // in karoserie
        if (($_GET['price'] == 'DESC' || $_GET['price'] == 'ASC') && isset($_GET['karoserie'])) {
            $ads = getCarByPrice($offset, $_GET['karoserie'], $_GET['price']);
        }
        // in all cars
        if (!isset($_GET['karoserie'])) {
            $ads = getCarByPriceAll($offset, $_GET['price']);
        }
    }

    // sort by year
    if (isset($_GET['year'])) {
        // in karoserie
        if (($_GET['year'] == 'DESC' || $_GET['year'] == 'ASC') && isset($_GET['karoserie'])) {
            $ads = getCarByYear($offset, $_GET['karoserie'], $_GET['year']);
        }
        // in all cars
        if (!isset($_GET['karoserie'])) {
            $ads = getCarByYearAll($offset, $_GET['year']);
        }
    }

    // sort by milage
    if (isset($_GET['milage'])) {
        // in karoserie
        if (($_GET['milage'] == 'DESC' || $_GET['milage'] == 'ASC') && isset($_GET['karoserie'])) {
            $ads = getCarByMilage($offset, $_GET['karoserie'], $_GET['milage']);
        }
        // in all cars
        if (!isset($_GET['karoserie'])) {
            $ads = getCarByMilageAll($offset, $_GET['milage']);
        }
    }

    // sort by power
    if (isset($_GET['power'])) {
        // in karoserie
        if (($_GET['power'] == 'DESC' || $_GET['power'] == 'ASC') && isset($_GET['karoserie'])) {
            $ads = getCarByPower($offset, $_GET['karoserie'], $_GET['power']);
        }
        // in all cars
        if (!isset($_GET['karoserie'])) {
            $ads = getCarByPowerAll($offset, $_GET['power']);
        }
    }

    // if there are no ads, print error
    if ($ads == null) {
        echo "No ads found";
        exit();
    }

    // display all cars
    foreach ($ads as $ad): ?>

    <div class="ad">
        <a href="ad.php?id=<?php echo $ad['id'] ?>"><img src="<?php echo $ad['photo'] ?>" class="photo" alt="car photo"></a>
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
        </div>
    </div>

<?php endforeach; ?>
