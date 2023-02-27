<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

class branchController extends Controller
{
    public function index(Request $request)
    {
        $branches = branch::all();
       if ($request->ajax()) {
          //  $data = branch::all();
            $data = DB::table('branches')->select('branch_id','branch_name','department_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" class="btn btn-warning "
                    data-toggle="modal" data-target="#editModal'.$row->branch_id.'">
                    edit
                </button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('admin.branchMag',compact('branches'));
        // compact('branchs') คือ ส่งค่าตัวแปร

    }
    public function store(Request $request)
    {
        // dd($request->branch_name);
        $request->validate(
            [
                'branch_name' => 'required|unique:branches|max:50'
            ],
            [
                'branch_name.required' => "กรุณากรอกข้อมูล",
                'branch_name.unique' => "มีสาขานี้ในระบบแล้ว",
                'branch_name.max' => "ความยาวตัวอักษรเกิน 50 ตัวอักษร"
            ]
        );
        //บันทึก
        $branch = new branch();
        $branch->branch_name = $request->branch_name;
        $data["u_id"] = Auth::user()->u_id;
        $branch->save();
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function delete($branch_id)
    {
        //  dd($branch_id);
        $delete = DB::table('branches')->where('branch_id',$branch_id)->delete();
        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อย"); //ลบแบบไม่หาย

    }

    public function update(Request $request,$branch_id){
        //dd($request);
        //กรองข้อมูล
        $request->validate([
            'branch_name'=>'required|unique:branches|max:50'
        ],
        ['branch_name.required'=>"กรุณากรอกข้อมูล",
        'branch_name.unique'=>"มีชื่อนี้ในระบบแล้ว",
        'branch_name.max'=>"ความยาวตัวอักษรเกิน 50 ตัวอักษร"
        ]);
    $update = DB::table('branches')
                ->where('branch_id',$branch_id)
                ->update(['branch_name'=>$request->branch_name]);
   // dd($update);
    return redirect()->back()->with('success', "แก้ไขข้อมูลเรียบร้อย"); //ลบแบบไม่หาย
        
    }
}
