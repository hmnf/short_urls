<?php

class Model
{
    private PDO $db;
    private string $tableName;
    private array $data = [];
    private mixed $id_value;

    public function __construct()
    {
        $this->db = (new Database)->pdo;
        if ($this->table) {
            $this->tableName = $this->table;
        } else {
            $this->tableName = strtolower(get_called_class()) . 's';
        }
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    public static function findById(int|float|string $id)
    {
        $className = get_called_class();
        $model = new $className;
        $id_name = 'id';
        if ($model->id_name) {
            $id_name = $model->id_name;
        }
        $request = $model->db->prepare("SELECT * FROM $model->tableName WHERE $id_name = $id");
        $request->execute();
        $queryResult = $request->fetch(PDO::FETCH_ASSOC);
        if($queryResult){
            $model->id_value = $id;
            foreach($queryResult as $key => $value){
                $model->$key = $value;
            }
            return $model;
        }else{
            return false;
        }
    }

    public function store(): void
    {

        $classKeys = array_keys($this->data);
        $classKeysColons = [];
        foreach ($classKeys as $keys) {
            $keys = ':' . $keys;
            $classKeysColons[] = $keys;
        }
        $classKeysColons = implode(',', $classKeysColons);
        $classKeys = implode(',', $classKeys);
        $prep = $this->db->prepare(
            "INSERT INTO $this->tableName ($classKeys)
            VALUES($classKeysColons)"
        );



        if (!$this->isEmpty($this->data)) {
            foreach ($this->data as $key => $value) {
                $prep->bindValue($key, $value);
            }
            $prep->execute();
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo "Fill All Of The Fields";
        }
    }

    public function update()
    {
    
    }

    public function delete(): bool
    {
        $id_name = 'id';
        if ($this->id_name) {
            $id_name = $this->id_name;
        }
        $request = $this->db->prepare("DELETE FROM $this->tableName WHERE $id_name = $this->id_value");
        $request->execute();
        return true;
    }

    public static function findAll(): array
    {
        $model = new self;
        $request = $model->db->prepare("SELECT * FROM $model->tableName");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isEmpty(array $class)
    {
        foreach ($class as $elem) {
            if (empty($elem)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
