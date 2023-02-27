<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index2()
    {
        return view('dashboard2');
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function homeUser()
    {
        return view('users.home');
    }
    public function homeStaff()
    {
        
        return view('staff.home');
    }
    public function allDocs()
    {
        $DocsAll = DB::table('data_document')
        ->select('*')
        ->leftJoin('government', function ($join) {
            $join->on('government.government_id', '=', 'data_document.title_data');
        })
        ->leftJoin('data_types', function ($join) {
            $join->on('data_types.type_id', '=', 'data_document.type_id');
        })
        ->simplePaginate(10);
        return view('document.allDoc',compact('DocsAll'));
    }
}
