<?php

namespace App\Admin\Repositories;

use App\Models\LearningMaterialDetail as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LearningMaterialDetail extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
