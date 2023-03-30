<?php
    // if someone tries to access this file directly, redirect them to the 404 page
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        header("Location: 404.php");
    } 

    // connect to database using PDO
    $host = 'localhost';
    $name = 'morenmat';
    $password = 'webove aplikace';
    $database = 'morenmat';

    $db = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $name, $password);

    // next functions will do different things depending on the type of request

    // get all cars (don't care about type or order)
    function getCar()
    {
        global $db;
        $query = $db->query("SELECT * FROM cars");
        return $query;
    }

    // get 4 random cars (using on the index.php to get 4 random ads)
    function getCarRandom()
    {
        global $db;
        $query = $db->query("SELECT * FROM cars ORDER BY RAND() LIMIT 4");
        return $query;
    }

    // get cars with offset (using in cars.php to get $offset cars per page)
    function getCarOffset($offset)
    {
        global $db;
        $query = $db->query("SELECT * FROM cars LIMIT 5 OFFSET $offset");
        return $query;
    }

    // filter cars by type of car with offset (using in cars.php to get cars with $offset and type of car)
    function getCarKaroserie($offset, $karoserie)
    {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie' LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get car by id (using in ad.php to get the car with the id)
    function getCarById($id)
    {
        global $db;

        // if id is not a number, print error message
        if (!is_numeric($id)) {
            echo 'Takové id neexistuje!';
            exit();
        }

        $cars = $db->query("SELECT * FROM cars WHERE id = $id");
        foreach ($cars as $ad) {
            return $ad;
        }}


    // get name by email (using in ad.php to get the name of the user who posted the ad)
    function getNameByEmail($email)
    {
        global $db;
        $users = $db->query("SELECT * FROM users2 WHERE email = '$email'");
        foreach ($users as $user) {
            return $user;
        }
    }

    // get number of cars (using in index.php to show number of cars)
    function getNumberOfCars()
    {
        global $db;
        $cars = $db->query("SELECT * FROM cars");
        return $cars->rowCount();
    }

    // get number of cars by type of car (using in cars.php to create pagination)
    function getNumberOfCarsByKaroserie($karoserie)
    {
        global $db;
        $cars = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie'");
        return $cars->rowCount();
    }

    // get cars by price down with offset and type of car
    function getCarByPriceDown($offset, $karoserie)
    {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie' ORDER BY price DESC LIMIT 5 OFFSET $offset");
        return $query;
    }

    // next functions get sorted cars by filters on cars.php

    // get cars by price down or up with offset and type of car
    function getCarByPrice($offset, $karoserie, $price)
    {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie' ORDER BY price $price LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get cars by price down or up with offset
    function getCarByPriceAll($offset, $price)
    {
        global $db;
        $query = $db->query("SELECT * FROM cars ORDER BY price $price LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get cars by price down or up with offset
    function getCarByYear($offset, $karoserie, $year) {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie' ORDER BY year $year LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get cars by year down or up with offset
    function getCarByYearAll($offset, $year) {
        global $db;
        $query = $db->query("SELECT * FROM cars ORDER BY year $year LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get car by milage down or up with offset and type of car
    function getCarByMilage($offset, $karoserie, $milage) {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie' ORDER BY milage $milage LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get cars by milage down or up with offset
    function getCarByMilageAll($offset, $milage) {
        global $db;
        $query = $db->query("SELECT * FROM cars ORDER BY milage $milage LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get car by power down or up with offset and type of car
    function getCarByPower($offset, $karoserie, $power) {
        global $db;
        $query = $db->query("SELECT * FROM cars WHERE karoserie = '$karoserie' ORDER BY power $power LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get cars by power down or up with offset
    function getCarByPowerAll($offset, $power) {
        global $db;
        $query = $db->query("SELECT * FROM cars ORDER BY power $power LIMIT 5 OFFSET $offset");
        return $query;
    }

    // get car if user wants to edit it
    function getCarToEdit($id) {
        global $db;
        $cars = $db->query("SELECT * FROM cars WHERE id = $id");
        foreach ($cars as $ad) {
            return $ad;
        }
    }

    // check car by email and id and if belongs to user, return true
    function checkCar($id, $email) {
        global $db;
        $cars = $db->query("SELECT * FROM cars WHERE id = $id");
        foreach ($cars as $ad) {
            if ($ad['email'] == $email) {
                return true;
            }
        }
    }

