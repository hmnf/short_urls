<?php
class UserController
{

  public function getAll()
  {
    echo 'get all users';
  }

  public function getUser(Request $request, Response $response)
  {
    echo $response->json(["user_id" => $request->data["id"], "message" => "hello world!", "age" => 90]);
  }

  public function createUser(Request $request, Response $response)
  {
    echo $response->json(["request_name" => $request->data['name'], "age" => $request->args["age"]]);
  }
}
