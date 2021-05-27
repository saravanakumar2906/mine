<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
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
        return view('home');
    }
    public function home_ajx(Request $request)
    {
        $query = DB::table('performance')->whereuser_id(Auth::user()->id)->where('year',$request->year)->first();
        if($query){
        return $query->rate;
        }else {
            return 'no record found';
        }
       
    }

}
