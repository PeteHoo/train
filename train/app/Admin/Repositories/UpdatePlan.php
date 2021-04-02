<?php

namespace App\Admin\Repositories;

use App\Models\UpdatePlan as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class UpdatePlan extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
