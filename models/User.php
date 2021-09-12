<?php
require './models/Post.php';

class User extends Model{
    protected string $table = 'users';
    protected string $custom_id = 'id';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}