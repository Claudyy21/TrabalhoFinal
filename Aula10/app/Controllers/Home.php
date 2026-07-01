<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/home');
    }

    public function errors(){
        return $this->response->setStatusCode(401)->setBody(view('errors/html/error_401'));
    }
}
