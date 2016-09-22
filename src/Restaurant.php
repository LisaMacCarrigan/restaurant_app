<?php

    class Restaurant {

        private $id;
        private $name;
        private $cuisine_id;
        private $rating;

        function __construct($name_input, $cuisine_id_input, $rating_input, $id = null) {
            $this->name = $name_input;
            $this->cuisine_id = $cuisine_id_input;
            $this->rating = $rating_input;
            $this->id = $id;
        }

        function getRating() {
            return $this->rating;
        }

        function setRating($rating_input) {
            $this->rating = $rating_input;
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
                $rating = $restaurant['rating'];
                $new_restaurant = new Restaurant($name, $cuisine_id, $rating, $id);
                array_push($restaurants, $new_restaurant);
            }

            return $restaurants;
        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO restaurant (name, cuisine_id, rating) VALUES ('{$this->getName()}', {$this->getCuisineId()}, {$this->getRating()});");
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

        function updateName($new_name) {
            $GLOBALS['DB']->exec("UPDATE restaurant SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function updateRating($new_rating) {
            $GLOBALS['DB']->exec("UPDATE restaurant SET rating = '{$new_rating}' WHERE id = {$this->getId()};");
            $this->setRating($new_rating);
        }

    }

?>
