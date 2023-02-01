<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'MyPDO.php';


try {
    $mbd = new MyPDO();
    //PROBAR CON FETCH_NUM, FETCH_ASSOC, FETCH_BOTH
    $pdostmt = $mbd->query('SELECT *'
            . ' from books where title like \'P%\' ');
    while( ($row = $pdostmt->fetch(PDO::FETCH_OBJ))
            !==false) {
       echo "<pre>";
       print_r($row);
       echo"</pre>";
       //solo con FETCH_OBJ
       echo $row->book_id;
    }
    
    //sentencias preparadas con parámetros 
    
     $pdostmt = $mbd->prepare('SELECT *'
            . ' from books where title like :nombre ');
     $filtro = "P%";
     $pdostmt->bindParam("nombre", $filtro);
     $pdostmt-> execute();
    while( ($row = $pdostmt->fetch(PDO::FETCH_OBJ))
            !==false) {
       echo "<pre>";
       print_r($row);
       echo"</pre>";
       echo $row->book_id;
    }
    
     $pdostmt = $mbd->query('SELECT b.title, concat(COALESCE(a.first_name,\'\'), \' \', COALESCE(a.middle_name, \'\'), \' \',   COALESCE(a.last_name, \'\')) as name'
            . ' from books b '
             . 'INNER JOIN book_authors ba ON b.book_id = ba.book_id '
             . 'INNER JOIN authors a on ba.author_id=a.author_id ');
    
    while( ($row = $pdostmt->fetch(PDO::FETCH_ASSOC))
            !==false) {
       echo "<pre>";
       print_r($row);
       echo"</pre>";
      
    }
    
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}