<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\branch;
use stdClass;
use App\Models\dataType;
use App\Models\document;
use App\Models\government;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use DataTables;

class DeanController extends Controller
{
    public function index(Request $request)
    {
        $user = User::all();
        $branch = branch::all();
        $permission = DB::table('permission')->select('*')->get();
        $loadDocs = DB::table('data_document')
            ->select('*')
            ->leftJoin('government', function ($join) {
                $join->on('government.government_id', '=', 'data_document.title_data');
            })->leftJoin('data_types', function ($join) {
                $join->on('data_types.type_id', '=', 'data_document.type_id');
            })
           ->get();

            if ($request->ajax()) {
                //  $data = branch::all();
                $data = DB::table('data_document')
                ->select('*')
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })->leftJoin('data_types', function ($join) {
                    $join->on('data_types.type_id', '=', 'data_document.type_id');
                })->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<button type="button" class="btn btn-info " data-toggle="modal"
                            data-target="#info' . $row->docs_id . '">
                            info
                        </button>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }


        return view('dean.home', compact('loadDocs', 'permission', 'user', 'branch'));
    }

    public function addMessenger(Request $request)
    {
        $request->validate(
            [
                'docs_name' => 'required|max:255',
                'path_data' => 'required|mimes:pdf'
            ],
            [
                'docs_name.required' => "กรุณากรอกข้อมูล",
                'docs_name.unique' => "มีข้อมูลนี้ในระบบแล้ว",
                'docs_name.max' => "ความยาวตัวอักษรเกิน 255 ตัวอักษร"
            ]
        );
        if ($request->permission[0] == 1) {   // 1 ทุกคน

            
            //    dd($userid);
            // บันทึก
            $path_data = $request->file('path_data');
            //เปลี่ยนชื่อรูปภาพ เข้ารหัสชื่อรุปภาพ เป็นเลขฐาน 10
            $name_gen =  hexdec(uniqid());
            //ดึงนามสกุลไฟล์
            $docs_ext = strtolower($path_data->getClientOriginalExtension());
            $file_name = $name_gen . '.' . $docs_ext;
            //save
            $upload_location = 'file/document/';
            $full_path = $upload_location . $file_name;
            $active = '0';
            $data_document =  DB::table('data_document')->insertGetId([
                'title_data' => 12,
                'type_id' => 5,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => 1,
                'active' => $active,
                'permission_id' => '1',
                'view_docs' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()

            ]);
            $path_data->move($upload_location, $file_name);

            $userid = DB::table('users')->select('id')->pluck('id');
            $x = 0;
            for ($i = 0; $i < count($userid); $i++) {
                $user_reactive = DB::table('user_reactive')->insertGetId([   // เพิ่ม ข้อมูล รายบุคคล
                    'docs_id' => $data_document,
                    'u_id' => $userid[$x],
                    'reactive' => '0',
                    'reactive_at' => now()
                ]);
                $x++;
            }
            $showTable = DB::table('showdoc')->insert([
                'docs_id' => $data_document,
            ]);
           

            return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
        } elseif ($request->permission[0] == 2) {  //สาขา 

            // บันทึก
            $path_data = $request->file('path_data');
            //เปลี่ยนชื่อรูปภาพ เข้ารหัสชื่อรุปภาพ เป็นเลขฐาน 10
            $name_gen =  hexdec(uniqid());
            //ดึงนามสกุลไฟล์
            $docs_ext = strtolower($path_data->getClientOriginalExtension());
            $file_name = $name_gen . '.' . $docs_ext;
            //save
            $upload_location = 'file/document/';
            $full_path = $upload_location . $file_name;
            $active = '0';
            $data_document =  DB::table('data_document')->insertGetId([
                'title_data' => 12,
                'type_id' => 5,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => 1,
                'active' => $active,
                'permission_id' => '2',
                'view_docs' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()

            ]);
            $userbranch = DB::table('users')->select('id');
            foreach ($request->selectRecipient as $row) {
                $userbranch->orWhere('branch_id', $row);
            }
            $result = $userbranch->pluck('id');

            $x = 0;
            for ($i = 0; $i < count($result); $i++) {
                $user_reactive = DB::table('user_reactive')->insertGetId([   // เพิ่ม ข้อมูล รายบุคคล
                    'docs_id' => $data_document,
                    'u_id' => $result[$x],
                    'reactive' => '0'
                  
                ]);
                $x++;
            }
            // dd($user_reactive);
            $x = 0;
            for ($i = 0; $i < count($request->selectRecipient); $i++) {
                $branch_reactive = DB::table('branch_reactive')->insertGetId([   // เพิ่ม user_reactive
                    'docs_id' => $data_document,
                    'branch_id' => $request->selectRecipient[$x],
                    'reactive' => '0',
                    'reactive_at' => now()
                ]);
                $showTable = DB::table('showdoc')->insert([
                    'docs_id' => $data_document,
                    'branch_reactive_id' => $branch_reactive,
                ]);
                $x++;
            }
            $path_data->move($upload_location, $file_name);

            return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
            
        } elseif ($request->permission[0] == 3) {  //ภาควิทย์
            // บันทึก
            $path_data = $request->file('path_data');
            //เปลี่ยนชื่อรูปภาพ เข้ารหัสชื่อรุปภาพ เป็นเลขฐาน 10
            $name_gen =  hexdec(uniqid());
            //ดึงนามสกุลไฟล์
            $docs_ext = strtolower($path_data->getClientOriginalExtension());
            $file_name = $name_gen . '.' . $docs_ext;
            //save
            $upload_location = 'file/document/';
            $full_path = $upload_location . $file_name;
            $active = '0';
            $data_document =  DB::table('data_document')->insertGetId([
                'title_data' => 12,
                'type_id' => 5,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => 1,
                'active' => $active,
                'permission_id' => '3',
                'view_docs' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()

            ]);
            $path_data->move($upload_location, $file_name);

            $userdepartment = DB::table('users')->select('id')->orWhere('department_id', '=', 1);
            $result = $userdepartment->pluck('id');
            $x = 0;
            for ($i = 0; $i < count($result); $i++) {
                $user_reactive = DB::table('user_reactive')->insertGetId([   // เพิ่ม ข้อมูล รายบุคคล
                    'docs_id' => $data_document,
                    'u_id' => $result[$x],
                    'reactive' => '0'
                    
                ]);
                $x++;
            }
            $dos_reactive = DB::table('dos_reactive')->insertGetId([   // เพิ่ม user_reactive
                'docs_id' => $data_document,
                'reactive' => '0',
                'department_id' => '1',
                'reactive_at' => now()
            ]);
            $showTable = DB::table('showdoc')->insert([
                'docs_id' => $data_document,
                'dos_reactive_id' => $dos_reactive
            ]);
            if (count($request->permission) > 1) {
                $userdepartment = DB::table('users')->select('id')->orWhere('department_id', '=', 2);
                $result = $userdepartment->pluck('id');
                $x = 0;
                for ($i = 0; $i < count($result); $i++) {
                    $user_reactive = DB::table('user_reactive')->insertGetId([   // เพิ่ม ข้อมูล รายบุคคล
                        'docs_id' => $data_document,
                        'u_id' => $result[$x],
                        'reactive' => '0'
                    
                    ]);
                    $x++;
                }
                $doas_reactive = DB::table('doas_reactive')->insertGetId([   // เพิ่ม user_reactive
                    'docs_id' => $data_document,
                    'reactive' => '0',
                    'department_id' => '2',
                    'reactive_at' => now()
                ]);
                $showTable = DB::table('showdoc')->insert([
                    'docs_id' => $data_document,
                    'doas_reactive_id' => $doas_reactive
                ]);
            } else {
                return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
            }
            return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
        } elseif ($request->permission == 4) {  //ภาควิทย์ประยุกต์
            // บันทึก
            $path_data = $request->file('path_data');
            //เปลี่ยนชื่อรูปภาพ เข้ารหัสชื่อรุปภาพ เป็นเลขฐาน 10
            $name_gen =  hexdec(uniqid());
            //ดึงนามสกุลไฟล์
            $docs_ext = strtolower($path_data->getClientOriginalExtension());
            $file_name = $name_gen . '.' . $docs_ext;
            //save
            $upload_location = 'file/document/';
            $full_path = $upload_location . $file_name;
            $active = '0';
            $data_document =  DB::table('data_document')->insertGetId([
                'title_data' => 12,
                'type_id' => 5,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => 1,
                'active' => $active,
                'permission_id' => '4',
                'view_docs' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()

            ]);
            $userdepartment = DB::table('users')->select('id')->orWhere('department_id', '=', 2);
            $result = $userdepartment->pluck('id');
            $x = 0;
            for ($i = 0; $i < count($result); $i++) {
                $user_reactive = DB::table('user_reactive')->insertGetId([   // เพิ่ม ข้อมูล รายบุคคล
                    'docs_id' => $data_document,
                    'u_id' => $result[$x],
                    'reactive' => '0'
                    
                ]);
                $x++;
            }
            $doas_reactive = DB::table('doas_reactive')->insertGetId([   // เพิ่ม user_reactive
                'docs_id' => $data_document,
                'reactive' => '0',
                'department_id' => '2',
                'reactive_at' => now()
            ]);
            $showTable = DB::table('showdoc')->insert([
                'docs_id' => $data_document,
                'doas_reactive_id' => $doas_reactive
            ]);

            $path_data->move($upload_location, $file_name);

            return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
        } elseif ($request->permission[0] == 6) {   //รายบุคคล

            // บันทึก
            $path_data = $request->file('path_data');
            //เปลี่ยนชื่อรูปภาพ เข้ารหัสชื่อรุปภาพ เป็นเลขฐาน 10
            $name_gen =  hexdec(uniqid());
            //ดึงนามสกุลไฟล์
            $docs_ext = strtolower($path_data->getClientOriginalExtension());
            $file_name = $name_gen . '.' . $docs_ext;

            //save
            $upload_location = 'file/document/';
            $full_path = $upload_location . $file_name;
            $active = '0';
            $data_document =  DB::table('data_document')->insertGetId([
                'title_data' => 12,
                'type_id' => 5,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => 1,
                'permission_id' => '6',
                'active' => $active,
                'view_docs' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()

            ]);
            $x = 0;
            for ($i = 0; $i < count($request->selectRecipient); $i++) {
                $user_reactive = DB::table('user_reactive')->insertGetId([   // เพิ่ม user_reactive
                    'docs_id' => $data_document,
                    'u_id' => $request->selectRecipient[$x],
                    'reactive' => '0'
                    
                ]);
                $showTable = DB::table('showdoc')->insert([
                    'docs_id' => $data_document,
                    'user_reactive_id' => $user_reactive
                ]);
                $x++;
            }

            $path_data->move($upload_location, $file_name);

            //     dd($data_document);
            return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
        } else {
            // บันทึก
            // $path_data = $request->file('path_data');
            // //เปลี่ยนชื่อรูปภาพ เข้ารหัสชื่อรุปภาพ เป็นเลขฐาน 10
            // $name_gen =  hexdec(uniqid());
            // //ดึงนามสกุลไฟล์
            // $docs_ext = strtolower($path_data->getClientOriginalExtension());
            // $file_name = $name_gen . '.' . $docs_ext;
            // //save
            // $upload_location = 'file/document/';
            // $full_path = $upload_location . $file_name;
            // $active = '0';
            // $data_document =  DB::table('data_document')->insert([
            //     'title_data' => $request->title_data,
            //     'type_id' => $request->type_id,
            //     'docs_name' => $request->docs_name,
            //     'book_number' => $request->book_number,
            //     'docs_date' => $request->docs_date,
            //     'path_data' => $full_path,
            //     'docs_detail' => $request->docs_detail,
            //     'priority' => $request->priority,
            //     'active' => $active,
            //     'permission_id' => '5',
            //     'view_docs' => auth()->user()->id,
            //     'created_at' => now(),
            //     'updated_at' => now()

            // ]);
            // $path_data->move($upload_location, $file_name);

            return redirect()->back()->with('error', "บันทึกข้อมูลล้มเหลว");
        }
    }
}
