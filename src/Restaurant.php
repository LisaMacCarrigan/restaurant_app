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

        function getCuisineId() {
            return $this->cuisine_id;
        }

        static function getAll() {

        }

        function save() {
            $GLOBALS['DB']->exec("INSERT INTO restaurant (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM restaurant;");
        }

    }

?>
