<?php

require './database/Database.php';
require './models/User.php';

class Auth{

    public function Registration(Request $request, Response $response) 
    {
        $user = new User($request->data);
    }

    public function Login() 
    {

    }


}