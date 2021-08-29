<?php
class UserController
{

  public function getAll()
  {
    echo 'get all users';
  }

  public function getUser(Request $request, Response $response)
  {
    $user = new User;
    $user->id = $request->data['id'];
    
    return $response->json($user->findById($user->id));
  }

  public function createUser(Request $request, Response $response)
  {
    $user = new User;
    // $user->firstName = $request->data['firstName'];
    // $user->lastName = $request->data['lastName'];
    // $user->email = $request->data['email'];
    // $user->login = $request->data['login'];
    // $user->phone = $request->data['phone'];
    // $user->password = $request->data['password'];

    $user->store($request->data);
  }
}
