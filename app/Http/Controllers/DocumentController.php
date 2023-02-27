<?php

namespace App\Http\Controllers;

use App\Models\branch;
use App\Models\dataType;
use App\Models\document;
use App\Models\government;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use stdClass;
use DataTables;

use function Psy\debug;

class DocumentController extends Controller
{

    public function index()
    {
        return view('document.index');
    }
    // public function docsType()
    // {
    //     $data_type =  dataType::simplePaginate(10);
    //     return view('document.docs',compact('data_type'));
    // }

    public function docsAll(Request $request)
    {

        $user = User::all();
        $data_type = dataType::all();
        $branch = branch::all();
        $permission = DB::table('permission')->select('*')->get();
        $government = DB::table('government')->select('government_id', 'government_name')->get();
        $docs_all = DB::table('data_document')->select('*')->orderByDesc('docs_id')->simplePaginate(10);
        $documentJoin = DB::table('data_document')
            ->select('*')
            ->leftJoin('government', function ($join) {
                $join->on('government.government_id', '=', 'data_document.title_data');
            })
            ->leftJoin('data_types', function ($join) {
                $join->on('data_types.type_id', '=', 'data_document.type_id');
            })->where('data_document.view_docs', '=', auth()->user()->id)->orderByDesc('docs_id')
            ->get();

        if ($request->ajax()) {
            //  $data = branch::all();
            $data =  DB::table('data_document')
                ->select('*')
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })
                ->leftJoin('data_types', function ($join) {
                    $join->on('data_types.type_id', '=', 'data_document.type_id');
                })->where('data_document.view_docs', '=', auth()->user()->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="btn btn-warning "
                          data-toggle="modal" data-target="#editModal' . $row->docs_id . '">
                          edit
                      </button>';
                    return $actionBtn;
                })

                ->addColumn('action2', function ($row) {
                    $actionBtn2 = '<button type="button" class="btn btn-info " data-toggle="modal"
                        data-target="#info' . $row->docs_id . '">
                        info
                    </button>';
                    return $actionBtn2;
                })
                ->rawColumns(['action', 'action2'])
                ->make(true);
        }

        return view('document.docs', compact('government', 'data_type', 'docs_all', 'documentJoin', 'permission', 'user', 'branch'));
    }
    public function docsAll2(Request $request)
    {
        $user = User::all();
        $data_type = dataType::all();
        $branch = branch::all();
        $permission = DB::table('permission')->select('*')->get();
        $government = DB::table('government')->select('government_id', 'government_name')->get();
        $docs_all = DB::table('data_document')->select('*')->simplePaginate(10);

        $documentJoin = DB::table('data_document')
            ->select('*')
            ->leftJoin('government', function ($join) {
                $join->on('government.government_id', '=', 'data_document.title_data');
            })
            ->leftJoin('data_types', function ($join) {
                $join->on('data_types.type_id', '=', 'data_document.type_id');
            })->where('data_document.view_docs', '=', auth()->user()->id)->orderByDesc('docs_id')
            ->get();
        // dd($documentJoin);
        if ($request->ajax()) {
            //  $data = branch::all();
            $data =  DB::table('data_document')
                ->select('*')
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })
                ->leftJoin('data_types', function ($join) {
                    $join->on('data_types.type_id', '=', 'data_document.type_id');
                })->where('data_document.view_docs', '=', auth()->user()->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="btn btn-warning "
                          data-toggle="modal" data-target="#editModal' . $row->docs_id . '">
                          edit
                      </button>';
                    return $actionBtn;
                })

                ->addColumn('action2', function ($row) {
                    $actionBtn2 = '<button type="button" class="btn btn-info " data-toggle="modal"
                        data-target="#info' . $row->docs_id . '">
                        info
                    </button>';
                    return $actionBtn2;
                })
                ->rawColumns(['action', 'action2'])
                ->make(true);
        }
        return view('document.docs2', compact('government', 'data_type', 'docs_all', 'documentJoin', 'permission', 'user', 'branch'));
    }

    public function storeDocument(Request $request)
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
                'title_data' => $request->title_data,
                'type_id' => $request->type_id,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => $request->priority,
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
                'title_data' => $request->title_data,
                'type_id' => $request->type_id,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => $request->priority,
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
                'title_data' => $request->title_data,
                'type_id' => $request->type_id,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => $request->priority,
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
                'title_data' => $request->title_data,
                'type_id' => $request->type_id,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => $request->priority,
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
                'title_data' => $request->title_data,
                'type_id' => $request->type_id,
                'docs_name' => $request->docs_name,
                'book_number' => $request->book_number,
                'docs_date' => $request->docs_date,
                'path_data' => $full_path,
                'docs_detail' => $request->docs_detail,
                'priority' => $request->priority,
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
    public function storeType(Request $request)
    {
        $request->validate(
            [
                'type_name' => 'required|unique:data_types|max:30'
            ],
            [
                'type_name.required' => "กรุณากรอกข้อมูล",
                'type_name.unique' => "มีข้อมูลนี้ในระบบแล้ว",
                'type_name.max' => "ความยาวตัวอักษรเกิน 30 ตัวอักษร"
            ]
        );
        // บันทึก
        $data_type = new dataType();
        $data_type->type_name = $request->type_name;
        $data["id"] = Auth::user()->id;
        $data_type->save();
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }
    //Government
    public function storeGovern(Request $request)
    {
        $request->validate(
            [
                'government_name' => 'required|unique:government|max:255'
            ],
            [
                'government_name.required' => "กรุณากรอกข้อมูล",
                'government_name.unique' => "มีข้อมูลนี้ในระบบแล้ว",
                'government_name.max' => "ความยาวตัวอักษรเกิน 255 ตัวอักษร"
            ]
        );
        // บันทึก
        $government = DB::table('government')->insert([
            'government_name' => $request->government_name,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $data["id"] = Auth::user()->id;
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function updateDoc(Request $request)
    {
        $update = DB::table('data_document')->update([
            'title_data' => $request->title_date,
            'type_id' => $request->type_id,
            'book_number' => $request->book_number,
            'docs_name' => $request->docs_name,
            'docs_detail' => $request->docs_detail,
            'docs_date' => $request->docs_date,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }
}
