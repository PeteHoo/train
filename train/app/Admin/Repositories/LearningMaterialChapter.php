<?php

namespace App\Admin\Repositories;

use App\Models\LearningMaterialChapter as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class LearningMaterialChapter extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
