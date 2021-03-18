<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller{
    
    public function __construct(){
        $this->middleware(['auth']);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('home');
    }

    public function adminHome(){
        return view('admin_home');
    }

    public function providerHome(){
        return view('provider_home');
    }
}
