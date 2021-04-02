<?php

namespace App\Admin\Repositories;

use App\Models\Mechanism as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Mechanism extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
