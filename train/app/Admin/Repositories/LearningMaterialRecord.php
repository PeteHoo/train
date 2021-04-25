<?php

namespace App\Admin\Repositories;

use App\Models\LearningMaterialRecord as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LearningMaterialRecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
