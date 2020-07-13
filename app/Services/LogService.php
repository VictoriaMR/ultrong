<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Logger;

class LogService extends BaseService
{
	public function __construct(Logger $logger)
    {
        $this->baseModel = $logger;
    }

    public function create($data)
    {
    	return $this->baseModel->insert($data);
    }
}