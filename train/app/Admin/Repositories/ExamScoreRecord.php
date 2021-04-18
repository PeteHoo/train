<?php

namespace App\Admin\Repositories;

use App\Models\ExamScoreRecord as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ExamScoreRecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
