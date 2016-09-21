<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost:8889;dbname=restaurant_app_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Cuisine::deleteAll();
        }

        function test_save() {

            // ARRANGE
            $id = null;
            $cuisine_type = "Tex-Mex";
            $test_cuisine = new Cuisine($id, $cuisine_type);
            $test_cuisine->save();

            // ACT
            $result = $test_cuisine::getAll();

            // ASSERT
            $this->assertEquals($test_cuisine, $result[0]);

        }

    }


?>
