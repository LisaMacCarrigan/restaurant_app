<?php

    class Cuisine {

        private $cuisine_type;
        private $id;

        function __construct($cuisine_type_input, $id = null) {
            $this->cuisine_type = $cuisine_type_input;
            $this->id = $id;
        }

        function getId() {
            return $this->id;
        }

        function setCuisineType($cuisine_type_input) {
            $this->cuisine_type = $cuisine_type_input;
        }

        function getCuisineType() {
            return $this->cuisine_type;
        }

        function getRestaurants() {
            $restaurants = array();

            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->getId()};");

            foreach ($returned_restaurants as $restaurant) {
                $name = $restaurant["name"];
                $cuisine_id = $restaurant["cuisine_id"];
                $rating = $restaurant["rating"];
                $id = $restaurant["id"];

                $new_restaurant = new Restaurant($name, $cuisine_id, $rating, $id);
                array_push($restaurants, $new_restaurant);
            }

            return $restaurants;
        }

        static function getAll() {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = array();
            foreach ($returned_cuisines as $cuisine) {
                $id = $cuisine['id'];
                $cuisine_type = $cuisine['cuisine_type'];
                $new_cuisine = new Cuisine($cuisine_type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (cuisine_type) VALUES ('{$this->getCuisineType()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }

        static function find($search_id) {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                    $found_cuisine = $cuisine;
                }
                return $found_cuisine;
            }
        }

        function update($new_type){
            $GLOBALS['DB']->exec("UPDATE cuisine SET cuisine_type = '{$new_type}' WHERE id = {$this->getId()};");
            $this->setCuisineType($new_type);
        }

    }

?>
