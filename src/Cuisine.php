<?php

    class Cuisine {

        private $id;
        private $cuisine_type;

        function __construct($id = null, $cuisine_type_input) {
            $this->id = $id;
            $this->cuisine_type = $cuisine_type_input;
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

        static function getAll() {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = array();
            foreach ($returned_cuisines as $cuisine) {
                $id = $cuisine['id'];
                $cuisine_type = $cuisine['cuisine_type'];
                $new_cuisine = new Cuisine($id, $cuisine_type);
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

    }

?>
