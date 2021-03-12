<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    protected function index()
    {
        return view('layouts.app');
    }

    protected function vue()
    {
        return redirect()->route('app.index');
    }
}
