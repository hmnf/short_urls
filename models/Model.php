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

    public function __get(string $name): mixed
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    public static function findById(int|float|string $id): object
    {
        $className = get_called_class();
        $model = new $className;
        $id_name = 'id';
        if ($model->id_name) {
            $id_name = $model->id_name;
        }
        $request = $model->db->prepare("SELECT * FROM $model->tableName WHERE $id_name = $id");
        $request->execute();
        $u = $request->fetchObject($className);
        $u->id_value = $id;
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
        $id_name = 'id';
        if ($this->id_name) {
            $id_name = $this->id_name;
        }
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

        $prep = $this->db->prepare(
            "UPDATE $this->tableName SET $arraySQL WHERE $id_name = $this->id_value"
        );

        foreach ($changedData as $key => $value) {
            $prep->bindValue($key, $value);
        }
        return $prep->execute();
    }



    public function delete(): bool
    {
        $id_name = 'id';
        if ($this->id_name) {
            $id_name = $this->id_name;
        }
        $request = $this->db->prepare("DELETE FROM $this->tableName WHERE $id_name = $this->id_value");
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
