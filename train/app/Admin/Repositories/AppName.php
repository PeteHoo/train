<?php

namespace App\Admin\Repositories;

use App\Models\AppName as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppName extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
