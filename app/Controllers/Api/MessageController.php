<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class MessageController extends ResourceController
{
    protected $modelName = 'App\Models\MessageModel';
    protected $format = 'json';

    public function store()
    {

    }

}
