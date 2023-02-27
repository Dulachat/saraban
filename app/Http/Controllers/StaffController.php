<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branch;
use App\Models\government;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use DataTables;

class StaffController extends Controller
{
    public function index()
    {

        return view('staff.home');
    }
    public function loadDocs(Request $request)
    {
        if (auth()->user()->department_id == 1) {
            $loadDocs = DB::table('dos_reactive')
                ->select('*')
                ->leftJoin('data_document', function ($join) {
                    $join->on('dos_reactive.docs_id', '=', 'data_document.docs_id');
                })
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })->where('dos_reactive.reactive', '=', '0')->orderByDesc('dos_reactive.reactive_id')
                ->get();

            if ($request->ajax()) {
                //  $data = branch::all();
                $data = DB::table('dos_reactive')
                    ->select('*')
                    ->leftJoin('data_document', function ($join) {
                        $join->on('dos_reactive.docs_id', '=', 'data_document.docs_id');
                    })
                    ->leftJoin('government', function ($join) {
                        $join->on('government.government_id', '=', 'data_document.title_data');
                    })->where('dos_reactive.reactive', '=', '0')
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<button type="button" class="btn btn-success "
                        data-toggle="modal"
                        data-target="#Reactive' . $row->reactive_id . '">
                        <i class="ni ni-check-bold"></i>
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
            return view('staff.home', compact('loadDocs'));
        } elseif (auth()->user()->department_id == 2) {
            $loadDocs = DB::table('doas_reactive')
                ->select('*')
                ->leftJoin('data_document', function ($join) {
                    $join->on('doas_reactive.docs_id', '=', 'data_document.docs_id');
                })
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })->where('doas_reactive.reactive', '=', '0')->orderByDesc('doas_reactive.reactive_id')
                ->get();

            if ($request->ajax()) {
                //  $data = branch::all();
                $data = DB::table('doas_reactive')
                    ->select('*')
                    ->leftJoin('data_document', function ($join) {
                        $join->on('doas_reactive.docs_id', '=', 'data_document.docs_id');
                    })
                    ->leftJoin('government', function ($join) {
                        $join->on('government.government_id', '=', 'data_document.title_data');
                    })->where('doas_reactive.reactive', '=', '0')
                    ->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<button type="button" class="btn btn-success "
                        data-toggle="modal"
                        data-target="#Reactive' . $row->reactive_id . '">
                        <i class="ni ni-check-bold"></i>
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
            return view('staff.home', compact('loadDocs'));
        } else {
            return redirect()->back()->with('error', "ลงรับหนังสือล้มเหลว");
        }
    }
    public function StaffDocsAll(Request $request)
    {
        if (auth()->user()->department_id == 1) {
            $UserDocsAll = DB::table('dos_reactive')
                ->select('*')
                ->leftJoin('data_document', function ($join) {
                    $join->on('dos_reactive.docs_id', '=', 'data_document.docs_id');
                })
                ->leftJoin('data_types', function ($join) {
                    $join->on('data_types.type_id', '=', 'data_document.type_id');
                })
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })->where('dos_reactive.reactive', '=', '1')
                ->get();

                if ($request->ajax()) {
                    //  $data = branch::all();
                    $data = DB::table('dos_reactive')
                    ->select('*')
                    ->leftJoin('data_document', function ($join) {
                        $join->on('dos_reactive.docs_id', '=', 'data_document.docs_id');
                    })
                    ->leftJoin('data_types', function ($join) {
                        $join->on('data_types.type_id', '=', 'data_document.type_id');
                    })
                    ->leftJoin('government', function ($join) {
                        $join->on('government.government_id', '=', 'data_document.title_data');
                    })->where('dos_reactive.reactive', '=', '1')
                    ->get();
    
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
            return view('staff.docAll', compact('UserDocsAll'));
        } elseif (auth()->user()->department_id == 2) {
            $UserDocsAll = DB::table('doas_reactive')
                ->select('*')
                ->leftJoin('data_document', function ($join) {
                    $join->on('doas_reactive.docs_id', '=', 'data_document.docs_id');
                })
                ->leftJoin('data_types', function ($join) {
                    $join->on('data_types.type_id', '=', 'data_document.type_id');
                })
                ->leftJoin('government', function ($join) {
                    $join->on('government.government_id', '=', 'data_document.title_data');
                })->where('doas_reactive.reactive', '=', '1')
                ->get();

                if ($request->ajax()) {
                    //  $data = branch::all();
                    $data = DB::table('doas_reactive')
                    ->select('*')
                    ->leftJoin('data_document', function ($join) {
                        $join->on('doas_reactive.docs_id', '=', 'data_document.docs_id');
                    })
                    ->leftJoin('data_types', function ($join) {
                        $join->on('data_types.type_id', '=', 'data_document.type_id');
                    })
                    ->leftJoin('government', function ($join) {
                        $join->on('government.government_id', '=', 'data_document.title_data');
                    })->where('doas_reactive.reactive', '=', '1')
                    ->get();
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
            return view('staff.docAll', compact('UserDocsAll'));
        } else {
            return redirect()->back()->with('error', "ลงรับหนังสือล้มเหลว");
        }
    }





    public function updateReactive(Request $request)
    {   //เจ้าหน้าที่ภาควิชา
        //  dd($request);
        if (auth()->user()->department_id == 1) {
            $reactiveDos = DB::table('dos_reactive')->where('docs_id', '=', $request->docs_id)->update([
                'reactive' => '1',
                'u_id' => auth()->user()->id,
                'reactive_number' => $request->reactive_number,
                'reactive_at' => now()
            ]);
        } elseif (auth()->user()->department_id == 2) {
            $reactiveDos = DB::table('doas_reactive')->where('docs_id', '=', $request->docs_id)->update([
                'reactive' => '1',
                'u_id' => auth()->user()->id,
                'reactive_number' => $request->reactive_number,
                'reactive_at' => now()
            ]);
        } else {
            return redirect()->back()->with('error', "ลงรับหนังสือล้มเหลว");
        }
        return redirect()->back()->with('success', "ลงรับหนังสือเรียบร้อย");
    }


    // $reactiveBranch = DB::table('branch_reactive')->where('docs_id', '=', $request->docs_id)->where('branch_id','=',auth()->user()->branch_id)->update([
    //     'reactive' => '1',
    //     'reactive_at' => now()
    // ]);
    // $reactiveDos = DB::table('dos_reactive')->where('docs_id', '=', $request->docs_id)->update([
    //     'reactive' => '1',
    //     'reactive_at' => now()
    // ]);
    // $reactiveDoas = DB::table('doas_reactive')->where('docs_id', '=', $request->docs_id)->update([
    //     'reactive' => '1',
    //     'reactive_at' => now()
    // ]);
}
