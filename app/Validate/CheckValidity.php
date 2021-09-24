<?php

    namespace App\Validate;

    class CheckValidity
    {
        public function checkInsertForm(string $name, string $surname, string $idNo): bool
        {
            if(trim($_POST[$name]) === '' || trim($_POST[$surname]) === '' || trim($_POST[$idNo]) === ''){
                echo "Invalid Input<br><br>";
                return false;
            }
            return true;
        }

        public function issetAndNotEmpty(string $search): bool
        {
            if(isset($_GET[$search]) && $_GET[$search] !== ''){
                return true;
            }
            return false;
        }

        public function searchValidate(array $record, string $idNumber, string $search): bool
        {
            if($record[$idNumber] === $_GET[$search] || !isset($_GET[$search]) || $_GET[$search] === ''){
                return true;
            }
            return false;
        }
    }