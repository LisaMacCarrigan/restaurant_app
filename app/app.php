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



    // , array("restaurants" => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    // });

    $app->get("/cuisines", function() use ($app) {
        return $app["twig"]->render("cuisines.html.twig");
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

    return $app;


 ?>
