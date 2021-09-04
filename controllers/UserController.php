<?php
class UserController
{

  public function getAll()
  {
    echo 'get all users';
  }

  public function getUser(Request $request, Response $response)
  {
    $user = User::findById($request->data['id']);
    
    return $user;
  }

  public function createUser(Request $request, Response $response)
  {
    $user = new User;
    $user->first_name = $request->data['firstName'];
    $user->last_name = $request->data['lastName'];
    $user->email = $request->data['email'];
    $user->login = $request->data['login'];
    $user->phone = $request->data['phone'];
    $user->password = password_hash($request->data['password'], PASSWORD_DEFAULT);

    $user->store();
  }

  public function delete(Request $request, Response $response)
  {
    $id = $request->data['id'];
    $user = User::findById($id);
    if($user){
      // $user->delete();
      $first_name = $user->data["first_name"];
      return $response->json(['message' => "User $first_name deleted"]);
    } 
    
    return $response->json(['message' => "User not found"]);
  }

  public function update(Request $request, Response $response)
  {
    $id = $request->data['id'];
    $user = User::findById($id);
    $changedData["first_name"] = $request->data["first_name"];
    $changedData["last_name"] = $request->data["last_name"];
    $user->update($changedData);
  }
}
