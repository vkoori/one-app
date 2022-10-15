<?php

namespace App\Controllers\Shell\Model\Enum;

enum Model: string
{
	case NAMESPACE = 'App\\Database\\Model';
	case DIRECTORY = 'App/Database/Model/';
	case EXTEND = 'App\\Controllers\\Shell\\Model\\BaseModel';
}
