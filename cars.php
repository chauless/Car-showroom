<?php
    // require header template and connection to DB
    require 'templates/headerTemplate.php';
    require 'php/connect.php';

    // get all cars from database
    if (isset($_GET['karoserie'])) {
        // in case if we have karoserie in GET
        $count = getNumberOfCarsByKaroserie($_GET['karoserie']);
    } else {
        // other cases
        $count = getNumberOfCars();
    }

    // set the limit of cars per page
    $limit = 5; // number of cars to show per page
    $pageCount = ceil($count / $limit); // number of pages
?>

<link rel="stylesheet" href="css/cars.css">
		<main>
            <div class="ad">
                <!-- add filters icons to filter cars by price, age, milage and power -->
                <div class="filters">
                    <!-- get information about current page and add this parameter to the link -->
                    <a href="cars.php?page=<?php if (htmlspecialchars(isset($_GET['page']))) echo htmlspecialchars($_GET['page']);
                    if (htmlspecialchars(isset($_GET['karoserie']))) { ?>&karoserie=<?php echo htmlspecialchars($_GET['karoserie']); }?>&price=<?php
                    // switch between ascending and descending price
                    if (isset($_GET['price'])) {
                        if ($_GET['price'] == 'ASC') echo 'DESC';
                        else echo 'ASC';
                    } else echo 'ASC'; ?>"><img src="img/priceicon.png" alt="price">
                        <?php
                        // highlight the icon if the filter is ASC
                        if (isset($_GET['price']))
                            if ($_GET['price'] == 'ASC') echo '🠕';
                            else echo '🠗';
                        ?></a>

                    <!-- get information about current page and add this parameter to the link -->
                    <a href="cars.php?page=<?php if (htmlspecialchars(isset($_GET['page']))) echo htmlspecialchars($_GET['page']);
                    if (htmlspecialchars(isset($_GET['karoserie']))) { ?>&karoserie=<?php echo htmlspecialchars($_GET['karoserie']); }?>&year=<?php
                    // switch between ascending and descending karoserie
                    if (isset($_GET['year'])) {
                        if ($_GET['year'] == 'ASC') echo 'DESC';
                        else echo 'ASC';
                    } else echo 'ASC'; ?>"><img src="img/yearicon.png" alt="year">
                        <?php
                        // highlight the icon if the filter is ASC
                        if (isset($_GET['year']))
                            if ($_GET['year'] == 'ASC') echo '🠕';
                            else echo '🠗';
                        ?></a>

                    <!-- get information about current page and add this parameter to the link -->
                    <a href="cars.php?page=<?php if (htmlspecialchars(isset($_GET['page']))) echo htmlspecialchars($_GET['page']);
                    if (htmlspecialchars(isset($_GET['karoserie']))) { ?>&karoserie=<?php echo htmlspecialchars($_GET['karoserie']); }?>&milage=<?php
                    // switch between ascending and descending milage
                    if (isset($_GET['milage'])) {
                        if ($_GET['milage'] == 'ASC') echo 'DESC';
                        else echo 'ASC';
                    } else echo 'ASC'; ?>"><img src="img/milageicon.png" alt="milage"><?php
                        // highlight the icon if the filter is ASC
                        if (isset($_GET['milage']))
                            if ($_GET['milage'] == 'ASC') echo '🠕';
                            else echo '🠗';
                        ?></a>

                    <!-- get information about current page and add this parameter to the link -->
                    <a href="cars.php?page=<?php if (htmlspecialchars(isset($_GET['page']))) echo htmlspecialchars($_GET['page']);
                    if (htmlspecialchars(isset($_GET['karoserie']))) { ?>&karoserie=<?php echo htmlspecialchars($_GET['karoserie']); }?>&power=<?php
                    // switch between ascending and descending power
                    if (isset($_GET['power'])) {
                        if ($_GET['power'] == 'ASC') echo 'DESC';
                        else echo 'ASC';
                    } else echo 'ASC'; ?>"><img src="img/powericon.png" alt="power"><?php
                        // highlight the icon if the filter is ASC
                        if (isset($_GET['power']))
                            if ($_GET['power'] == 'ASC') echo '🠕';
                            else echo '🠗';
                        ?></a>
                    <!-- button to get rid of filters -->
                    <a href="cars.php?page=1">Smazat filtry</a>
                </div>
            </div>

            <!-- require cars template to show car list -->
			<?php require 'templates/carsTemplate.php'; ?>

		</main>

        <!-- show the pages -->
        <div class="pagelist">
            <?php for($i = 1; $i <= $pageCount; $i++) { ?>
                <a href="cars.php?page=<?php echo $i; ?><?php
                // check if we have filters in URL
                if(isset($_GET['karoserie'])) {
                    ?>&karoserie=<?php
                    echo htmlspecialchars($_GET['karoserie']);
                } if(isset($_GET['price'])) {
                    ?>&price=<?php
                    echo htmlspecialchars($_GET['price']);
                } if(isset($_GET['year'])) {
                    ?>&year=<?php
                    echo htmlspecialchars($_GET['year']);
                } if(isset($_GET['milage'])) {
                    ?>&milage=<?php
                    echo htmlspecialchars($_GET['milage']);
                } if(isset($_GET['power'])) {
                    ?>&power=<?php
                    echo htmlspecialchars($_GET['power']);
                }  ?>
                " <?php
                    // highlight the current page
                    if (htmlspecialchars(isset($_GET['page']))) {
                        if ($i == htmlspecialchars($_GET['page'])) echo 'class="pagebutton bold"';
                    } echo 'class="pagebutton"'
                ?>><?php echo $i; ?></a>
            <?php } ?>
        </div>
	</body>
</html>