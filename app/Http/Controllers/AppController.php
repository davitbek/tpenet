<?php

namespace App\Http\Controllers;

/**
 * Class AppController
 * @package App\Http\Controllers
 */
class AppController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app');
    }
}
