<?php

    namespace App\Custom\Error;

    trait Descriptions
    {
        public static function GetDescription ($code)
        {
            $errors = 
                [
                    '100' => 'PHP CODE COMPILATION FAILED'
                ];
            
            return (array_key_exists ($code, $errors)) ? $errors[$code] : $code;
        }
    }
?>