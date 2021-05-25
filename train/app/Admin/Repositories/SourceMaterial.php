<?php

namespace App\Admin\Repositories;

use App\Models\SourceMaterial as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SourceMaterial extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
