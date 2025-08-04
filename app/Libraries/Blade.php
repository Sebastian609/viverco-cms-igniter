<?php

namespace App\Libraries;

use Philo\Blade\Blade as PhiloBlade;

class Blade
{
    protected $blade;

    public function __construct()
    {
        $views = [APPPATH . 'Views'];
        $cache = WRITEPATH . 'cache';

        $this->blade = new PhiloBlade($views, $cache);
    }

    public function view($view, $data = [])
    {
        echo $this->blade->view()->make($view, $data)->render();
    }
}
