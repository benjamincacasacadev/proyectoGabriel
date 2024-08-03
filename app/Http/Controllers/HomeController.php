<?php

namespace App\Http\Controllers;

use App\WorkOrders;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        Session::put('item','0.');
        return view('home');
    }
}
