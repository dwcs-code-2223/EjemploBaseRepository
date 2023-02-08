<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of BaseRepository
 *
 * @author mfernandez
 */
abstract class BaseRepository implements IBaseRepository {

    protected string $table_name;
    protected string $pk_name;
     protected string $class_name;
     
     protected MyPDO $conn;   

    public function __construct() {
        $this->conn = new MyPDO();
    }

    abstract public function create($object);
    abstract public function update($object): bool;

    /**
     * Recupera un objeto de $class_name siempre y cuando tenga el mismo nombre en los atributos que en las columnas de la tabla
     * @param type $id  valor de la PK del registro a borrar
     * @return type el objeto creado de $class_name o null si no lo encuentra
     */
    public function read($id) {
        $pdostmt = $this->conn->prepare("SELECT * FROM $this->table_name "
                . "WHERE $this->pk_name = :id");
        $pdostmt->bindValue("id", $id);
        $pdostmt->execute();

        //Llama al constructor después de establecer las propiedades. No usa los métodos setters
        $object = $pdostmt->fetchObject($this->class_name);

        return $object;
    }

    

    
/**
 * Elimina un registro de la tabla asociada a $table_name
 * @param type $id valor de la PK del registro a borrar
 * @return bool <p>Devuelve true si se ha borrado, false en caso contrario</p>
 */
    public function delete($id): bool {
        $pdostmt = $this->conn->prepare(
                "DELETE FROM " . $this->table_name . " WHERE " . $this->pk_name
                . " = :id");
        //"DELETE FROM :table_name  WHERE :pk_name = :id");
//        $pdostmt->bindParam("table_name", $this->table_name);
//        $pdostmt->bindParam("pk_name", $this->pk_name);
        $pdostmt->bindValue("id", $id);

       // $pdostmt->debugDumpParams();
        $pdostmt->execute();
        return ($pdostmt->rowCount() == 1);
    }

}
