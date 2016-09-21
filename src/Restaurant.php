<?php

    class Restaurant {

        private $id;
        private $name;
        private $cuisine_id;

        function __construct($id = null, $name_input, $cuisine_id_input) {
            $this->id = $id;
            $this->name = $name_input;
            $this->cuisine_id = $cuisine_id_input;
        }

        function getId() {
            return $this->id;
        }

        function setName($name_input) {
            $this->name = $name_input;
        }

        function getName() {
            return $this->name;
        }

        function setCuisineId($cuisine_id_input) {
            $this->cuisine_id = $cuisine_id_input;
        }

        function getCuisineId() {
            return $this->cuisine_id;
        }

        static function getAll() {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");

            $restaurants = array();

            foreach($returned_restaurants as $restaurant) {

                $id = $restaurant['id'];
                $name = $restaurant['name'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($id, $name, $cuisine_id);
                array_push($restaurants, $new_restaurant);
            }

            return $restaurants;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO restaurant (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM restaurant;");
        }

        static function find($search_id) {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
                return $found_restaurant;
            }
        }

        function update($new_name) {
            $GLOBALS['DB']->exec("UPDATE restaurant SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

    }

?>
