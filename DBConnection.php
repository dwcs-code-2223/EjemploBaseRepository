<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$usuario="user-bookdb";
$contraseña="abc123.";
try {
    $mbd = new PDO('mysql:host=localhost;dbname=bookdb', $usuario, $contraseña);
    foreach($mbd->query('SELECT * from books') as $fila) {
       echo "<pre>";
       print_r($fila);
       echo"</pre>";
    }
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}