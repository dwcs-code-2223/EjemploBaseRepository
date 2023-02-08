<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Util {

    public static function stringToDateTimeISO8601($cadena): DateTimeImmutable {
        if (($date = DateTimeImmutable::createFromFormat('Y-m-d', $cadena)) !== false) {
            return $date;
        } else {
            echo "La conversión a date de $cadena no ha sido un éxito <br/>";
        }
        return null;
    }
}