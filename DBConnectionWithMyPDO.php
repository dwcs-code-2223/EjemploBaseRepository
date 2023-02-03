<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'MyPDO.php';

try {
    $mbd = new MyPDO();

    //PROBAR CON FETCH_NUM, FETCH_ASSOC, FETCH_BOTH
    $pdostmt = $mbd->query('SELECT * from books');

    echo "Consulta de todos los libros con query y fetch sin argumentos (equivalente a FETCH_BOTH) <br/>";
    while (($row = $pdostmt->fetch()) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";

        echo "Book id: " . $row[0] . " <br/>";
        echo "Book id: " . $row["book_id"] . " <br/>";
    }




    echo "Consulta de todos los libros con query y fetch mode= FETCH_NUM: <br/>";
    $pdostmt = $mbd->query('SELECT * from books');
    while (($row = $pdostmt->fetch(PDO::FETCH_NUM)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
        echo "Book id: " . $row[0] . " <br/>";
    }


    echo "Consulta de todos los libros con query y fetch mode= FETCH_ASSOC: <br/>";
    $pdostmt = $mbd->query('SELECT * from books');
    while (($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
        echo "Book id: " . $row["book_id"] . " <br/>";
    }


    echo "Consulta de todos los libros con query y fetch mode= FETCH_OBJ: <br/>";
    $pdostmt = $mbd->query('SELECT * from books');
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";

        //Con FETCH_OBJ se usa -> para acceder a una fila
        echo "Book id: " . $row->book_id . " <br/>";
    }




    //sentencias preparadas con parámetros  con sustitución con variables
    echo "Consultas preparadas con parámetros nominales y sustitución con variables: Títulos que comienzan por P";
        $pdostmt = $mbd->prepare('SELECT * from books where title like :nombre ');
        $filtro = "P%";
        $pdostmt->bindParam("nombre", $filtro);
        $pdostmt->execute();
        while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
            echo "<pre>";
            print_r($row);
            echo"</pre>";
        }

    //sentencias preparadas con parámetros  con sustitución con variables
    echo "Consultas preparadas con parámetros nominales y sustitución con valores: Títulos que comienzan por P";
    $pdostmt = $mbd->prepare('SELECT * from books where title like :nombre ');
    $pdostmt->bindValue("nombre", "P%");
    $pdostmt->execute();
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }


    echo "Parámetros posicionales: Títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $mbd->prepare('SELECT * from books where title like ? or isbn like ? ');
    $filtro_title = "P%";
    $filtro_isbn = "%38%";
    $pdostmt->bindParam(1, $filtro_title);
    $pdostmt->bindParam(2, $filtro_isbn);
    $pdostmt->execute();
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
    
    
     echo "Parámetros nominales en array: Títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $mbd->prepare('SELECT * from books where title like :nombre or isbn like :isbn ');
    
    $pdostmt->execute( array("nombre"=> "P%", "isbn"=> "%38%" ));
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
    
     echo "Parámetros posicionales en array: Títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $mbd->prepare('SELECT * from books where title like ? or isbn like ? ');
    
    $pdostmt->execute( array("P%", "%38%" ));
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }

    echo "Selección de libros y sus autores:";
    $pdostmt = $mbd->query('SELECT b.title, concat(COALESCE(a.first_name,\'\'), \' \', COALESCE(a.middle_name, \'\'), \' \',   COALESCE(a.last_name, \'\')) as name'
            . ' from books b '
            . 'INNER JOIN book_authors ba ON b.book_id = ba.book_id '
            . 'INNER JOIN authors a on ba.author_id=a.author_id ');

    while (($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
    
    
      echo "Selección de libros y sus autores con group_concat: https://mariadb.com/kb/en/group_concat/";
    $pdostmt = $mbd->query('SELECT b.title,'
            . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
            . ' from books b '
            . ' INNER JOIN book_authors ba ON b.book_id = ba.book_id '
            . ' INNER JOIN authors a on ba.author_id=a.author_id'
            . ' GROUP BY b.title ');

    while (($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }

    $pdostmt=null;
    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}