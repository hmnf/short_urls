<?php

class Model
{
    private PDO $db;
    private string $tableName;
    private array $data = [];
    private array $extraData = [];
    private string $id_name = 'id';
    private string $query;
    private string $foreighClassName;
    private string $relationsColumnName;

    public function __construct()
    {
        $this->db = (new Database)->pdo;

        $this->relationsColumnName = strtolower(get_called_class()) . '_id';

        if($this->custom_id){
            $this->id_name = $this->custom_id;
        }

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

    public function __get(string $name): mixed
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    public function get()
    {
        $request = $this->db->prepare($this->query);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, $this->foreignClassName);
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function orderBy(string $columnName, string $order)
    {
        $this->query .= " ORDER BY $columnName $order";
        return $this;
    }
    
    protected function hasMany(string $className, string $relationColumn = null)
    {
        $model = new $className;
        $tableName = $model->getTableName();
        

        if($relationColumn){
            $this->relationsColumnName = $relationColumn;
        }

        $this->foreignClassName = $className;
        $this->query = "SELECT * FROM $tableName WHERE $this->relationsColumnName = $this->id";
        return $this;
    }

    public static function findById(int|float|string $id): object
    {
        $className = get_called_class();
        $model = new $className;
        $request = $model->db->prepare("SELECT * FROM $model->tableName WHERE $model->id_name = $id");
        $request->execute();
        $u = $request->fetchObject($className);
        return $u;
    }

    public function store(): bool
    {

        $classKeys = array_keys($this->data);
        $classKeysColons = [];
        foreach ($classKeys as $keys) {
            $keys = ":$keys";
            $classKeysColons[] = $keys;
        }
        $classKeysColons = implode(',', $classKeysColons);
        $classKeys = implode(',', $classKeys);
        $prep = $this->db->prepare(
            "INSERT INTO $this->tableName ($classKeys)
            VALUES($classKeysColons)"
        );

        foreach ($this->data as $key => $value) {
            $prep->bindValue($key, $value);
        }
        return $prep->execute();
    }

    public function update(array $changedData): bool
    {
        $array_keys = [];
        $array_keys_colons = [];
        foreach ($changedData as $key => $value) {
            $array_keys[] = $key;
            $key = ":$key";
            $array_keys_colons[] = $key;
        }
        $count = count($array_keys);
        for ($i = 0; $i < $count; $i++) {
            $arraySQL[] = "{$array_keys[$i]}={$array_keys_colons[$i]}";
        }

        $arraySQL = implode(',', $arraySQL);
        $id_name = $this->id_name;

        $prep = $this->db->prepare(
            "UPDATE $this->tableName SET $arraySQL WHERE $id_name = {$this->$id_name}"
        );

        foreach ($changedData as $key => $value) {
            $prep->bindValue($key, $value);
        }
        return $prep->execute();
    }



    public function delete(): bool
    {
        $id_name = $this->id_name;
        $request = $this->db->prepare("DELETE FROM $this->tableName WHERE $id_name = {$this->$id_name}");
        return $request->execute();
    }

    public static function findAll(): array
    {
        $model = new self;
        $request = $model->db->prepare("SELECT * FROM $model->tableName");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }
}
