<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $totemData = $this->getTotemData();

        return view('home', [
            'totemData' => $totemData,
        ]);
    }
}