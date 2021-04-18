<?php

namespace App\Admin\Repositories;

use App\Models\Special as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Special extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
