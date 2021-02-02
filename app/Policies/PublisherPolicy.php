<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRight;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublisherPolicy
{
    use HandlesAuthorization;

    const MODEL = 'publisher';

    public function __construct(){}

    private function checkRight(User $user, String $right){
        return UserRight::where('user_id', $user->id)
            ->where('right', $right)
            ->where('model', self::MODEL)
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
    public function update(User $user){
        return $this->checkRight($user, 'update');
    }

    //DELETE
    public function delete(User $user){
        return $this->checkRight($user, 'delete');
    }
}
