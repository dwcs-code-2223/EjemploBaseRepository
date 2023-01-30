<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'MyPDO.php';


try {
    $mbd = new MyPDO();
    
    $pdostmt = $mbd->query('SELECT *'
            . ' from books where title like \'P%\' ');
    while( ($row = $pdostmt->fetch(PDO::FETCH_OBJ))
            !==false) {
       echo "<pre>";
       print_r($row);
       echo"</pre>";
       echo $row->book_id;
    }
    
    //sentencias preparadas con parámetros 
    
     $pdostmt = $mbd->prepare('SELECT *'
            . ' from books where title like :nombre ');
     $pdostmt->bindValue("nombre", "P%");
     $pdostmt-> execute();
    while( ($row = $pdostmt->fetch(PDO::FETCH_OBJ))
            !==false) {
       echo "<pre>";
       print_r($row);
       echo"</pre>";
       echo $row->book_id;
    }
    
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}