<?php

class User{
    private Database $db;
    public int $err = 0;

    public function __construct(array $data)
    {
        $this->db = new Database;
        $prep = $this->db->pdo->prepare(
            "INSERT INTO users (first_name, last_name, phone, login, email, password)
            VALUES(:first_name, :last_name, :phone, :login, :email, :password)"
        );

        $this->isEmpty($data["firstName"]);
        $this->isEmpty($data["lastName"]);
        $this->isEmpty($data["phone"]);
        $this->isEmpty($data["login"]);
        $this->isEmpty($data["email"]);
        $this->isEmpty($data["password"]);

        if($this->err == 0){
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

            $prep->bindParam(':first_name', $data["firstName"]);
            $prep->bindParam(':last_name', $data["lastName"]);
            $prep->bindParam(':phone', $data["phone"]);
            $prep->bindParam(':login', $data["login"]);
            $prep->bindParam(':email', $data["email"]);
            $prep->bindParam(':password', $data["password"]);
            
            $prep->execute();
        }else{
            header("HTTP/1.1 400 Bad Request");
            echo "Fill All Of The Fields";
        }
    }

    public function isEmpty($elem)
    {
        if(empty($elem)){
            $this->err = 1;
        }
    }
}