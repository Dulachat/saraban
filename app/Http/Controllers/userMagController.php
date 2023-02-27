<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branch;
use App\Models\title_name;
use App\Models\User;
use App\Models\user_level;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;
use DataTables;

class userMagController extends Controller
{
    public function index(Request $request)
    {
        $allbranch = branch::all();
        $allu_status = user_level::all();
        $department = DB::table('department')->select('*')->get();
   //     dump($department);
        $title = title_name::all();
        // $u_status =  DB::table('user_level')->select('u_level_id','lv_name')->get();

        $user_table = DB::table('users')
            ->join('branches', 'users.branch_id', '=', 'branches.branch_id')
            ->join('user_levels', 'users.u_level_id', '=', 'user_levels.u_level_id')
            ->join('title_names', 'users.title_name_id','=','title_names.title_name_id')
            ->select('users.*', 'branches.*', 'user_levels.*','title_names.*')->orderByDesc('id')
            ->get();

            if ($request->ajax()) {
                //  $data = branch::all();
                  $data = DB::table('users')
                  ->join('branches', 'users.branch_id', '=', 'branches.branch_id')
                  ->join('user_levels', 'users.u_level_id', '=', 'user_levels.u_level_id')
                  ->join('title_names', 'users.title_name_id','=','title_names.title_name_id')
                  ->select('users.*', 'branches.*', 'user_levels.*','title_names.*')
                  ->get();
                 // dd($data);
                 
                  return DataTables::of($data)
                      ->addIndexColumn()
                      ->addColumn('action', function($row){
                          $actionBtn = '<button type="button" class="btn btn-warning "
                          data-toggle="modal" data-target="#editModal'.$row->id.'">
                          edit
                      </button>';
                          return $actionBtn;
                      })
                      ->rawColumns(['action'])
                      ->make(true);
              }
          // dd($user_table);
        return view('admin.userMag', compact('allbranch', 'allu_status', 'user_table','title','department'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|unique:users|max:50'
            ],
            [
                'username.required' => "กรุณากรอกข้อมูล",
                'username.unique' => "มีชื่อนี้ในระบบแล้ว",
                'username.max' => "ความยาวตัวอักษรเกิน 50 ตัวอักษร"
            ]
        );
        // บันทึก
        $user = new User;
        $user->username = $request->username;
        $user->title_name_id = $request->title_name_id;
        $user->fname_TH = $request->fname_TH;
        $user->lname_TH = $request->lname_TH;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->department_id = $request->department ;
        $user->branch_id = $request->branch_id;
        $user->u_level_id = $request->u_level_id;
        $user->password = Hash::make('1234');
        $user->save();
        // dd($user);
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function edit($id)
    {
        $user_edit =  User::find($id);
        return view('admin.userMag', compact('user_edit'));
    }

    public function update(Request $request, $id)
    {
        //dd($request);
        //กรองข้อมูล
        $request->validate(
            [
                'fname_TH' => 'max:50',
                'lname_TH' => 'max:50'
                
            ],
            [
                
                'fname_TH.max' => "ความยาวตัวอักษรเกิน 50 ตัวอักษร",   
                'lname_TH.max' => "ความยาวตัวอักษรเกิน 50 ตัวอักษร"
            ]
        );
        //Eloquen
        $update = User::find($id)->update([
            'branch_id' => $request->branch_id,
            'title_name' => $request->title_name,
            'fname_TH' => $request->fname_TH,
            'lname_TH' => $request->lname_TH,
            'email' => $request->email,
            'tel' => $request->tel,
            'branch_id' => $request->branch_id,
            'u_level_id' => $request->u_level_id
        ]);

        //Query builder
        // $update = DB::table('users')
        //         ->where('id',$id)
        //         ->update(['branch_id'=>$request->branch_id,
        //                 'title_name'=>$request->title_name,
        //                 'fname_TH'=>$request->fname_TH,
        //                 'lname_TH'=>$request->lname_TH,
        //                 'email'=>$request->email,
        //                 'tel'=>$request->tel,
        //                 'branch_id'=>$request->branch_id,
        //                 'u_level_id'=>$request->u_level_id]);
        // dd($update);
         return redirect()->back()->with('success', "แก้ไขข้อมูลเรียบร้อย"); //ลบแบบไม่หาย

    }
}
