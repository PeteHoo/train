<?php

namespace App\Admin\Repositories;

use App\Models\LearningMaterial as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LearningMaterial extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
