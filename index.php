<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require_once 'IBaseRepository.php';
require_once 'BaseRepository.php';

require_once './BookRepository.php';
require_once './MyPDO.php';
require_once 'Book.php';
require_once 'Util.php';

$book_repo = new BookRepository();

echo " Títulos y autores de libros <br/>";
$array = $book_repo->getLibrosYAutoresAgrupadosFetchAll();
echo "<pre>";
print_r($array);
echo"</pre>";

echo " Editores <br/>";
$editores = $book_repo->getEditores();
echo "<pre>";
print_r($editores);
echo"</pre>";

echo " Autores: <br/>";
$autores = $book_repo->getAutores();
echo "<pre>";
print_r($autores);
echo"</pre>";

echo "Búsqueda en título: <br/>";

$resultado = $book_repo->buscarPorAutorOTitulo("Y");
echo "<pre>";
print_r($resultado);
echo"</pre>";
echo "Búsqueda por varias palabras ";


$resultado = $book_repo->buscarPorAutorOTituloPalabras("PHP a b ");

echo "<pre>";
print_r($resultado);
echo"</pre>";
//
//
//
//Operaciones CRUD: Descomentar la que se desea probar
//
//
//readBook(6);
//createBook();
//readBook(7);
//updateBook(6);
//readBook(7);
//deleteBook(9);


function createBook() {
    global $book_repo;

    $book = new Book();
    $book->setTitle("Título 1");
    $book->setIsbn("fg-hi-jk");

    $date = DateTimeImmutable::
            createFromFormat("Y-m-d",
                    "2023-02-08");
    $book->setPublished_date($date);
    $book->setPublisher_id(1);
    $book_creado = $book_repo->create($book);
    if ($book_creado == null) {
        echo " No se ha creado el libro<br/>";
    } else {
        
    } echo " Se ha crado el libro con id: " . $book_creado->getBook_id();
}

function updateBook($id) {
    global $book_repo;
    $book = readBook($id);
    if ($book != null) {

//Modificamos algún dato del libro
        $book->setTitle("Título 1 v9");
        $book->setIsbn("fg-hi-jk  v8");

        $date = DateTimeImmutable::
                createFromFormat("Y-m-d",
                        "2023-02-01");
        $book->setPublished_date($date);
        $book->setPublisher_id(2);
        $exito = $book_repo->update($book);

        if (!$exito) {
            echo " No se ha actualizado el libro con id: $id <br/>";
        } else {
            echo " Se ha actualizado el libro con id: $id<br/>";
        }
    }
}

//$book->setBook_id(9);
//



function deleteBook($id) {
    global $book_repo;
    $exito = $book_repo->delete($id);
    if (!$exito) {
        echo " No se ha borrado el libro con id: $id<br/>";
    } else {
        echo " Se ha borrado el libro con id: $id <br/>";
    }
}

function readBook($id) {
    global $book_repo;
    $book = $book_repo->read($id);
    if ($book != null) {
        echo "<pre>";

        echo print_r($book);
        echo "</pre>";
    } else {
        echo "No existe el libro con id: $id";
    }
    return $book;
}

//

