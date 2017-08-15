<?php

namespace App\Contracts\Repository;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Support\Exceptions\Repository\RepositoryException;

abstract class BaseRepository implements RepositoryInterface
{
    use ValidatesRequests;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $modelClass = null;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var Container
     */
    protected $app;

    /**
     * BaseRepository constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->app = $container;
        $this->makeModel();
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    private function makeModel()
    {
        if (! $this->modelClass instanceof  Model) {
            throw new RepositoryException("Class {$this->model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $this->app->make($this->modelClass);
    }

}