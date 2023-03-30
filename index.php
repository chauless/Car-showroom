<?php

    // require header template and connection to DB
    require 'templates/headerTemplate.php';
    require 'php/connect.php';

    // if user left photo upload page without uploading a photo unset session variable
    if (isset($_GET['nophoto']) == true) {
        unset($_SESSION['milage']);
    }

?>

<link rel="stylesheet" href="css/style.css">

<main>
	<div class="ads">
        <!-- require the ads template to show ads -->
		<?php require 'templates/adsTemplate.php'; ?>
	</div>

	<div class="button">
        <!-- button to show how many cars are in the DB -->
		<a href="cars.php?page=1" class="find">Zobrazit všech <?php echo getNumberOfCars() ?> inzerátů</a>
	</div>
</main>
</body>
</html>