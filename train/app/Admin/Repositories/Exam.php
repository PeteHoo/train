<?php

namespace App\Admin\Repositories;

use App\Models\Exam as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Exam extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
