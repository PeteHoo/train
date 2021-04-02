<?php

namespace App\Admin\Repositories;

use App\Models\Occupation as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Occupation extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
