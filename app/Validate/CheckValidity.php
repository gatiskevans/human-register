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
    }