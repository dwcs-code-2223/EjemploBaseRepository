<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'MyPDO.php';
require_once 'Book.php';

function isPersistent($conn) {
    //É persistente?
    $persistente = $conn->getAttribute(PDO::ATTR_PERSISTENT);
    return $persistente;
}

function getLibrosFetch($conn) {
    //PROBAR CON FETCH_NUM, FETCH_ASSOC, FETCH_BOTH
    $pdostmt = $conn->query('SELECT * from books');

    echo "Consulta de todos los libros con query y fetch sin argumentos (equivalente a FETCH_BOTH) <br/>";
    while (($row = $pdostmt->fetch()) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";

        echo "Book id: " . $row[0] . " <br/>";
        echo "Book id: " . $row["book_id"] . " <br/>";
    }
    
}

function getLibrosFetchNum($conn) {
    echo "Consulta de todos los libros con query y fetch mode= FETCH_NUM: <br/>";
    $pdostmt = $conn->query('SELECT * from books');
    while (($row = $pdostmt->fetch(PDO::FETCH_NUM)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
        echo "Book id: " . $row[0] . " <br/>";
    }
}

function getLibrosFetchAssoc($conn) {
    echo "Consulta de todos los libros con query y fetch mode= FETCH_ASSOC: <br/>";
    $pdostmt = $conn->query('SELECT * from books');
    while (($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
        echo "Book id: " . $row["book_id"] . " <br/>";
    }
}

function getLibrosFetchObj($conn) {
    echo "Consulta de todos los libros con query y fetch mode= FETCH_OBJ: <br/>";
    $pdostmt = $conn->query('SELECT * from books');
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";

        //Con FETCH_OBJ se usa -> para acceder a una fila
        echo "Book id: " . $row->book_id . " <br/>";
    }
}

function getLibrosParamNominalesVariables($conn) {
    //sentencias preparadas con parámetros  con sustitución con variables
    echo "Consultas preparadas con parámetros nominales y sustitución con variables: Títulos que comienzan por P";
    $pdostmt = $conn->prepare('SELECT * from books where title like :nombre ');
    $filtro = "P%";
    $pdostmt->bindParam("nombre", $filtro);
    $pdostmt->execute();
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
}

function getLibrosParamNomBindValue($conn) {

    //sentencias preparadas con parámetros  con sustitución con variables
    echo "Consultas preparadas con parámetros nominales y sustitución con valores: Títulos que comienzan por P";
    $pdostmt = $conn->prepare('SELECT * from books where title like :nombre ');
    $pdostmt->bindValue("nombre", "P%");
    $pdostmt->execute();
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
}

function getLibrosParamPosicVariables($conn) {
    echo "Parámetros posicionales: Títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $conn->prepare('SELECT * from books where title like ? or isbn like ? ');
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
}

function getLibrosParamNomArray($conn) {
    echo "Parámetros nominales en array: Títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $conn->prepare('SELECT * from books where title like :nombre or isbn like :isbn ');

    $pdostmt->execute(array("nombre" => "P%", "isbn" => "%38%"));
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
}

function getLibrosFetchAll($conn) {
    echo "Para obtener todos los valores en un array: fetchAll():Todos los datos de book con títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $conn->prepare('SELECT * from books where title like :nombre or isbn like :isbn ');

    $pdostmt->execute(array("nombre" => "P%", "isbn" => "%38%"));
    $resultado = $pdostmt->fetchAll();
    echo "<pre>";
    print_r($resultado);
    echo"</pre>";
}

function getLibrosFetchAllObj($conn) {
    echo "Parámetros posicionales en array: Títulos que comienzan por P or que el isbn contenga 38";
    $pdostmt = $conn->prepare('SELECT * from books where title like ? or isbn like ? ');

    $pdostmt->execute(array("P%", "%38%"));
    while (($row = $pdostmt->fetch(PDO::FETCH_OBJ)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
}

function getLibrosYAutores($conn) {
    echo "Selección de libros y sus autores:";
    $pdostmt = $conn->query('SELECT b.title, concat(COALESCE(a.first_name,\'\'), \' \', COALESCE(a.middle_name, \'\'), \' \',   COALESCE(a.last_name, \'\')) as name'
            . ' from books b '
            . 'INNER JOIN book_authors ba ON b.book_id = ba.book_id '
            . 'INNER JOIN authors a on ba.author_id=a.author_id ');

    while (($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<pre>";
        print_r($row);
        echo"</pre>";
    }
}

function getLibrosYAutoresAgrupados($conn) {
    echo "Selección de libros y sus autores con group_concat: https://mariadb.com/kb/en/group_concat/";
    $pdostmt = $conn->query('SELECT b.title,'
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
}

function getLibrosYAutoresAgrupadosFetchAll($conn) {
    echo "FetchAll de libros y autores";
    $pdostmt = $conn->query('SELECT b.title,'
            . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
            . ' from books b '
            . ' INNER JOIN book_authors ba ON b.book_id = ba.book_id '
            . ' INNER JOIN authors a on ba.author_id=a.author_id'
            . ' GROUP BY b.title ');

    $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($array);
    echo"</pre>";
}

function getLibrosFetchAllOneColumn($conn) {
    echo "FetchAll de libros columna 0";
    $pdostmt = $conn->query('SELECT * FROM books');

    $array = $pdostmt->fetchAll(PDO::FETCH_COLUMN, 0);
    echo "<pre>";
    print_r($array);
    echo"</pre>";
}

function getLibrosFetchAllClassBook($conn) {
    echo "FetchAll de libros con class Book";
    $pdostmt = $conn->query('SELECT * FROM books');

    $array = $pdostmt->fetchAll(PDO::FETCH_CLASS, "Book");
    echo "<pre>";
    print_r($array);
    echo"</pre>";
}

function getLibrosYAutoresFetchAllClassBook($conn) {


    echo "FetchAll de libros y autores columna con class";
    $pdostmt = $conn->query('SELECT b.title,'
            . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as autores'
            . ' from books b '
            . ' INNER JOIN book_authors ba ON b.book_id = ba.book_id '
            . ' INNER JOIN authors a on ba.author_id=a.author_id'
            . ' GROUP BY b.title ');

    $array = $pdostmt->fetchAll(PDO::FETCH_CLASS, "Book");
    echo "<pre>";
    print_r($array);
    echo"</pre>";
}

try {
    $conn = new MyPDO();

    $persistente = isPersistent($conn);
    $valor = var_export($persistente, true);
    echo " É persistente?: $valor <br/>";

    //Diferentes tipos de obtención de resultados con PDO::FETCH_*
    getLibrosFetch($conn);
    getLibrosFetchNum($conn);
    getLibrosFetchAssoc($conn);
    getLibrosFetchObj($conn);

    //Consultas preparadas y diferentes tipos de parámetros
    getLibrosParamNominalesVariables($conn);
    getLibrosParamNomBindValue($conn);
    getLibrosParamPosicVariables($conn);
    getLibrosParamNomArray($conn);
    
    
    //Obtención de libros y autores 
    getLibrosYAutores($conn);
    getLibrosYAutoresAgrupados($conn);

    
    //FetchAll en un solo array
    getLibrosYAutoresAgrupadosFetchAll($conn);
    getLibrosFetchAll($conn);
    getLibrosFetchAllObj($conn);
    getLibrosFetchAllOneColumn($conn);
    getLibrosFetchAllClassBook($conn);

    //Libros y autores
    
    getLibrosYAutoresFetchAllClassBook($conn);

   
    $conn = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}