<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $server = "mysql:host=localhost:8889;dbname=restaurant_app";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array("twig.path" => __DIR__."/../views"));

    $app->get("/", function() use ($app) {
        return $app["twig"]->render("index.html.twig");
    });

//======================Cuisines: ====================================
    $app->get("/cuisines", function() use ($app) {
        return $app["twig"]->render("cuisines.html.twig", array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['cuisine']);
        $cuisine->save();
        return $app["twig"]->render("cuisines.html.twig", array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app["twig"]->render("cuisines.html.twig");
    });
//=====================Restaurants: ===============================
    $app->get("/restaurants", function() use ($app) {
        return $app["twig"]->render("restaurants.html.twig", array('cuisines' => Cuisine::getAll(), 'restaurants' => Restaurant::getAll()));
    });

    $app->post("/restaurants", function() use ($app) {
        $restaurant = new Restaurant($_POST['restaurant'], $_POST['cuisine_id'], $_POST['rating']);
        $restaurant->save();
        $chosen_cuisine = Cuisine::find($_POST['cuisine_id']);
        var_dump($_POST['cuisine_id']);
        var_dump($chosen_cuisine);
        var_dump($restaurant);
        return $app["twig"]->render("restaurants.html.twig", array('cuisines' => Cuisine::getAll(), 'restaurants' => $chosen_cuisine->getRestaurants()));
    });

    $app->post("/delete_restaurants", function() use ($app) {
        Restaurant::deleteAll();
        return $app["twig"]->render("restaurants.html.twig", array("cuisines" => Cuisine::getAll()));
    });

    return $app;


 ?>
