<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost:8889;dbname=restaurant_app_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_save() {

            // ARRANGE

            // create a cuisine
            $c_id = null;
            $c_type = "Tex-Mex";
            $test_cuisine = new Cuisine($c_id, $c_type);
            $test_cuisine->save();

            // create a restaurant
            $id = null;
            $name = "El Camino";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $cuisine_id);
            $test_restaurant->save();

            // ACT
            $result = Restaurant::getAll();

            // ASSERT
            $this->assertEquals($test_restaurant, $result[0]);

        }

        function test_getAll() {

            // ARRANGE

            // create a cuisine
            $c_id = null;
            $c_type = "Tex-Mex";
            $test_cuisine = new Cuisine($c_id, $c_type);
            $test_cuisine->save();

            // create a restaurants
            $id = null;
            $name = "El Camino";
            $cuisine_id1 = $test_cuisine->getId();
            $test_restaurant1 = new Restaurant($id, $name, $cuisine_id1);
            $test_restaurant1->save();

            $name = "Dos Segundos";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($id, $name, $cuisine_id2);
            $test_restaurant2->save();

            // ACT
            $result = Restaurant::getAll();

            // ASSERT
            $this->assertEquals([$test_restaurant1, $test_restaurant2], $result);

        }

        function test_delete() {

            // create a cuisine
            $c_id = null;
            $c_type = "Tex-Mex";
            $test_cuisine = new Cuisine($c_id, $c_type);
            $test_cuisine->save();

            // create a restaurants
            $id = null;
            $name = "El Camino";
            $cuisine_id1 = $test_cuisine->getId();
            $test_restaurant1 = new Restaurant($id, $name, $cuisine_id1);
            $test_restaurant1->save();

            $name = "Dos Segundos";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($id, $name, $cuisine_id2);
            $test_restaurant2->save();

            // ACT
            Cuisine::deleteAll();
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            // ASSERT
            $this->assertEquals([], $result);
        }



    }

?>
