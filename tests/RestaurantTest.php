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
            $test_cuisine = new Cuisine($c_type, $c_id);
            $test_cuisine->save();

            // create a restaurant
            $id = null;
            $name = "El Camino";
            $cuisine_id = $test_cuisine->getId();
            $rating = 1;
            $test_restaurant = new Restaurant($id, $name, $cuisine_id, $rating);
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
            $test_cuisine = new Cuisine($c_type, $c_id);
            $test_cuisine->save();

            // create a restaurants
            $id = null;
            $name = "El Camino";
            $cuisine_id1 = $test_cuisine->getId();
            $rating1 = 5;
            $test_restaurant1 = new Restaurant($id, $name, $cuisine_id1, $rating1);
            $test_restaurant1->save();

            $name = "Dos Segundos";
            $cuisine_id2 = $test_cuisine->getId();
            $rating2 = 2;
            $test_restaurant2 = new Restaurant($id, $name, $cuisine_id2, $rating2);
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
            $test_cuisine = new Cuisine($c_type, $c_id);
            $test_cuisine->save();

            // create a restaurants
            $id = null;
            $name = "El Camino";
            $cuisine_id1 = $test_cuisine->getId();
            $rating = 5;
            $test_restaurant1 = new Restaurant($id, $name, $cuisine_id1, $rating);
            $test_restaurant1->save();

            $name2 = "Dos Segundos";
            $cuisine_id2 = $test_cuisine->getId();
            $rating = 5;
            $test_restaurant2 = new Restaurant($id, $name2, $cuisine_id2, $rating);
            $test_restaurant2->save();

            // ACT
            Cuisine::deleteAll();
            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            // ASSERT
            $this->assertEquals([], $result);

        }

        function test_find() {

            // ARRANGE
            $c_id = null;
            $c_type = "Tex-Mex";
            $test_cuisine = new Cuisine($c_type, $c_id);
            $test_cuisine->save();

            $id = null;
            $name = "El Gordos";
            $cuisine_id = $test_cuisine->getId();
            $rating = 5;
            $test_restaurant = new Restaurant($id, $name, $cuisine_id, $rating);
            $test_restaurant->save();

            // ACT
            $result = Restaurant::find($test_restaurant->getId());

            // ASSERT
            $this->assertEquals($test_restaurant, $result);

        }

        function testUpdateName() {

            //ARRANGE
            // create a cuisine
            $c_id = null;
            $c_type = "Greek";
            $test_cuisine = new Cuisine($c_type, $c_id);
            $test_cuisine->save();

            // create a restaurant
            $id = null;
            $name = "Kostas";
            $cuisine_id = $test_cuisine->getId();
            $rating = 5;
            $test_restaurant = new Restaurant($id, $name, $cuisine_id, $rating);
            $test_restaurant->save();

            $new_name = "Costas Bar";

            //ACT
            $test_restaurant->updateName($new_name);

            //ASSERT
            $this->assertEquals("Costas Bar", $test_restaurant->getName());

        }
        function testUpdateRating() {

            //ARRANGE
            // create a cuisine
            $c_id = null;
            $c_type = "Greek";
            $test_cuisine = new Cuisine($c_type, $c_id);
            $test_cuisine->save();

            // create a restaurant
            $id = null;
            $name = "Kostas";
            $cuisine_id = $test_cuisine->getId();
            $rating = 5;
            $test_restaurant = new Restaurant($id, $name, $cuisine_id, $rating);
            $test_restaurant->save();

            $new_rating = 2;

            //ACT
            $test_restaurant->updateRating($new_rating);

            //ASSERT
            $this->assertEquals(2, $test_restaurant->getRating());

        }

    }

?>
