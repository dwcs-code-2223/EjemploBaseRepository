<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require_once './BookRepository.php';
require_once './MyPDO.php';

$book_repo = new BookRepository();

//echo " Títulos y autores de libros <br/>";
//$array = $book_repo->getLibrosYAutoresAgrupadosFetchAll();
//echo "<pre>";
//print_r($array);
//echo"</pre>";
//
//echo " Editores <br/>";
//$editores = $book_repo->getEditores();
//echo "<pre>";
//print_r($editores);
//echo"</pre>";
//
//echo " Autores: <br/>";
//$autores = $book_repo->getAutores();
//echo "<pre>";
//print_r($autores);
//echo"</pre>";
//
//echo "Búsqueda en título: <br/>";
//
//$resultado = $book_repo->buscarPorAutorOTitulo("Y");
//echo "<pre>";
//print_r($resultado);
//echo"</pre>";

echo "Búsqueda por varias palabras ";

$cadena = $_GET["search"];
$resultado = $book_repo->buscarPorAutorOTituloPalabras("PHP a b ");

echo "<pre>";
print_r($resultado);
echo"</pre>";
