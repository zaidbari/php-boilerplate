<?php

namespace App\Core;

use App\Traits\Authorization;
use App\Traits\Request;
use App\Traits\Validation;
use App\Traits\View;

class Controller
{
    use Authorization, Validation, Request, View;
}
