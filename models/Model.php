<?php

class Model{
    private PDO $db;
    private string $tableName;
    private int $err = 0;

    public function __construct()
    {
        $this->db = (new Database)->pdo;
        if($this->table){
            $this->tableName = $this->table;
        }else{
            $this->tableName = strtolower(get_called_class()). 's';
        }
    }

    public function findById(int $id)
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName WHERE `id` = $id");
        $request->execute();
        return $request->fetch(PDO::FETCH_ASSOC);
    }

    public function store(array $class): void
    {
        $classKeys = array_keys($class);
        $classKeysColons = [];
        foreach($classKeys as $keys){
            $keys = ':'.$keys;
            $classKeysColons[] = $keys;
        }
        $classKeysColons = implode(',', $classKeysColons);
        $classKeys = implode(',', $classKeys);
        $prep = $this->db->prepare(
            "INSERT INTO $this->tableName ($classKeys)
            VALUES($classKeysColons)"
        );

        $this->isEmpty($class);

        if($this->err == 0){
            foreach($class as $key => $value){
                if($key == "password"){
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }
                $prep->bindParam($key, $value);
            }
            $prep->execute();
        }else{
            header("HTTP/1.1 400 Bad Request");
            echo "Fill All Of The Fields";
        }
    }
    
    public function findAll(): array
    {
        $request = $this->db->prepare("SELECT * FROM $this->tableName");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }
        
    public function isEmpty(array $class)
    {
        foreach($class as $elem){
            if(empty($elem)){
                $this->err = 1;
            }
        }    
    }
}