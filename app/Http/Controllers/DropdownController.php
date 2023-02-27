<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    public function index(){


        return view('document.docs');
    }

    public function fetch(Request $request){
        dd($request);

        // $id=$request->get('select');
        // $res=array();
        // $query=DB::table('users')->select('*')->get();
        // $output = ' <option value="">เลือกรายชื่อ</option>';
        // foreach($query as $row){
        //     $output.=` <option value="'.$row->fname_TH.''.$row->lname_TH.' ">'.$row->fname_TH.''.$row->lname_TH.'</option>`;
        // }
        // echo $output ;
        
        
        return view('document.docs');
    }
}
