<?php
class User
{
  public function __construct($method)
  { 
    $this->$method();
  }

  public function getAll()
  {
    echo 'get all users';
  }

  public function getUser()
  {
    echo 'get one user';
  }
}
