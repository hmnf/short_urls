<?php

class User{
    private Database $db;

    public function __construct(array $data)
    {
        $this->db = new Database;
        $prep = $this->db->pdo->prepare(
            "INSERT INTO users (first_name, last_name, phone, login, email, password)
            VALUES(:first_name, :last_name, :phone, :login, :email, :password)"
        );
        
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        $prep->bindParam(':first_name', $data["firstName"]);
        $prep->bindParam(':last_name', $data["lastName"]);
        $prep->bindParam(':phone', $data["phone"]);
        $prep->bindParam(':login', $data["login"]);
        $prep->bindParam(':email', $data["email"]);
        $prep->bindParam(':password', $data["password"]);
        
        $prep->execute();
    }
}