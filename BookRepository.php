<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of BookRepository
 *
 * @author mfernandez
 */
class BookRepository {

    private MyPDO $conn;

    public function __construct() {
        $this->conn = new MyPDO();
    }

    function getLibrosYAutoresAgrupadosFetchAll() {

        $pdostmt = $this->conn->query('SELECT b.title,'
                . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
                . ' from books b '
                . ' INNER JOIN book_authors ba ON b.book_id = ba.book_id '
                . ' INNER JOIN authors a on ba.author_id=a.author_id'
                . ' GROUP BY b.title ');

        $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);

        return $array;
    }

    function getEditores() {
        $pdostmt = $this->conn->query('SELECT publisher_id, name ' .
                ' FROM publishers ORDER BY name');
        $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    function getAutores() {
        $pdostmt = $this->conn->query('SELECT author_id, '
                . 'CONCAT (COALESCE(a.first_name,\'\'), '
                . 'COALESCE(\' \'+a.middle_name+\' \', \' \' ),'
                . 'COALESCE(a.last_name, \'\') ) as author ' .
                ' FROM authors a ORDER BY a.first_name');
        $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    function buscarPorAutorOTitulo($cadena) {
        $pdostmt = $this->conn->prepare(                
                 'SELECT T.title, T.name FROM ('
                . 'SELECT b.title,'
                . ' GROUP_CONCAT(COALESCE(a.first_name,\'\'),  COALESCE(\' \'+a.middle_name+\' \', \' \' ),    COALESCE(a.last_name, \'\') SEPARATOR \', \') as name'
                . ' from books b '
                . ' LEFT JOIN book_authors ba ON b.book_id = ba.book_id '
                . ' LEFT JOIN authors a on ba.author_id=a.author_id '
              
                . ' GROUP BY b.title '
                . ') as T WHERE T.name LIKE ? OR  T.title LIKE ? ');

        $criterio= "%" . $cadena . "%";
        $pdostmt->bindParam(1,$criterio );
        $pdostmt->bindParam(2,$criterio );
        $pdostmt->execute();

        $array = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

}
