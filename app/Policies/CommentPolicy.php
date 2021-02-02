<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\UserRight;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    const MODEL = 'comment';

    public function __construct(){}

    private function checkRight(User $user, String $right){
        return UserRight::where('user_id', $user->id)
            ->where('right', $right)
            ->where('model', self::MODEL)
            ->exists();
    }

    private function checkUser(User $user, Comment $comment){
        return Comment::where('user_id', $user->id)
            ->where('id', $comment->id)
            ->exists();
    }

    //CREATE
    public function create(User $user){
        return $this->checkRight($user, 'create');
    }

    //READ
    public function read(User $user){
        return $this->checkRight($user, 'read');
    }

    //UPDATE
    public function update(User $user, Comment $comment){
        return $this->checkUser($user, $comment);
    }

    //DELETE
    public function delete(User $user, Comment $comment){
        return $this->checkUser($user, $comment);
    }
}
