<?php

namespace App\Controllers;

use App\Core\Controller;

class Dashboard extends Controller
{

    public function index() : void
    {
        $this->authorize();
        $meta = [ 'title' => 'Dashboard' ];
        $this->view('dashboard/index', compact('meta'));
    }
}
