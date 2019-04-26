<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as Module;
use App\Http\Requests\User\OnlyUserRequest;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.dashboard.dashboard');
    }

    public function dashboard() {

        $data['total_user'] = Module::count();
        $only = new OnlyUserRequest();
        if($only->authorize()){
            $data['total_user'] = Module::where('created_by', user()->id)->count();
        }
        return view('backend.dashboard.dashboard', $data);
    }
}
