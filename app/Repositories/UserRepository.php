<?php

namespace App\Repositories;

use App\Contracts\Repository\{BaseRepository, UserRepositoryInterface};
use App\Entities\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var \App\Entities\User
     */
    protected $modelClass = User::class;


}