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
    $user->posts();

    // foreach($user->posts as $post){
      
    // }

    // $user->first_name;

    echo '<pre>';
    var_dump($user);
    echo '</pre>';
    
    // return $response->json(['user' => $user]);
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
      return $response->json(['message' => "User $user->first_name deleted"]);
    } 
    
    return $response->json(['message' => "User not found"]);
  }

  public function update(Request $request, Response $response)
  {
    $id = $request->data['id'];
    $user = User::findById($id);
    if(array_key_exists('password', $request->data)){
      $request->data['password'] = password_hash($request->data['password'], PASSWORD_DEFAULT);
    }
    $user->update($request->data);
  }
}
