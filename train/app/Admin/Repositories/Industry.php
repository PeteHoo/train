<?php

namespace App\Admin\Repositories;

use App\Models\Industry as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Industry extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
