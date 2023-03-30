<?php
    // require header template and connection to DB
    require 'templates/headerTemplate.php';
    require 'php/connect.php';

    // get car id and then get name of the owner
    if (isset($_GET['id'])) {
        $car = getCarById($_GET['id']);

        // if car is not found, print error message
        if ($car == '') {
            echo 'Takové id neexistuje!';
            exit();
        }

        // if car is found, get owner name
        $name = getNameByEmail($car['email']);
    } else {
        // if car id is not set, print error message
        echo 'Nebylo zadáno id!';
        exit();
    }


?>
<link rel="stylesheet" href="css/ad.css">
		<main>
            <!-- photo of the car -->
			<img src="<?php echo htmlspecialchars($car['photo']) ?>" class="photo" alt="">
			<div class="disc">
                <!-- brand + model + price -->
				<div class="price">
				<h2><?php echo htmlspecialchars($car['brand']) . ' ' . htmlspecialchars($car['model']) ?></h2>
				<h2><?php echo htmlspecialchars($car['price']) ?> CZK</h2>
				</div>

                <!-- description -->
				<div class="parametrs">
					<div class="name">
						<p>Rok</p>
						<p>Najeto</p>
						<p>Karoserie</p>
						<p>Barva</p>
						<p>Výkon</p>
						<p>Palivo</p>
					</div>

                    <!-- values of the description -->
					<div class="data">
						<p><?php echo htmlspecialchars($car['year']) ?></p>
						<p><?php echo htmlspecialchars($car['milage']) ?> km</p>
						<p><?php echo htmlspecialchars($car['karoserie']) ?></p>
						<p><?php echo htmlspecialchars($car['color']) ?></p>
						<p><?php echo htmlspecialchars($car['power']) ?> hp</p>
						<p><?php echo htmlspecialchars($car['palivo']) ?></p>
					</div>
				</div>

                <!-- car description -->
				<div class="text">
					<h2>Popis</h2>
					<p><?php echo htmlspecialchars($car['desc']) ?></p>
				</div>

                <!-- contacts -->
				<div class="contacts">
					<p><?php echo htmlspecialchars($name['name']) ?></p>
					<a href="mailto:<?php echo $car['email'] ?>">Poslat zprávu</a>
					<a class ="print-doc" href="javascript:(print());">Tisknout inzerát</a>
				</div>
			</div>
		</main>
	</body>
</html>