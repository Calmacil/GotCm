<?php

/**
 * Created by PhpStorm.
 * User: calmacil
 * Date: 28/12/15
 * Time: 00:14
 */

namespace Got\Action;

use Got\Core\Controller;

class Home extends Controller
{
    protected $template = "home";

    public function execAction()
    {
        return true;
    }
}