<?php

namespace App\Http\Controllers;

use App\Models\branch;
use App\Models\government;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Symfony\Component\ErrorHandler\Debug;

class UserhomeController extends Controller
{
    public function index()
    {

        return view('users.home');
    }
    public function loadAllDocs()
    {
        // $loadDocs = DB::table('user_reactive')
        //     ->select('*')
        //     ->leftJoin('data_document', function ($join) {
        //         $join->on('user_reactive.docs_id', '=', 'data_document.docs_id');
        //     })
        //     ->leftJoin('government', function ($join) {
        //         $join->on('government.government_id', '=', 'data_document.title_data');
        //     })
        //     ->where('user_reactive.u_id', '=', auth()->user()->id)->where('user_reactive.reactive', '=', '0')->orderByDesc('reactive_id')
        //     ->simplePaginate(20);

        $loadDocs = DB::table('user_reactive')->select('*')
        ->leftJoin('data_document', function ($join) {
            $join->on('user_reactive.docs_id', '=', 'data_document.docs_id');
        })
        ->leftJoin('government', function ($join) {
            $join->on('government.government_id', '=', 'data_document.title_data');
        })->where('user_reactive.u_id' ,'=', auth()->user()->id)->where('user_reactive.reactive', '=', '0')->orderByDesc('reactive_id')->simplePaginate(10);
        return view('users.home', compact('loadDocs'));
    }

    public function UserDocsAll()
    {
        $UserDocsAll = DB::table('user_reactive')->select('*')
        ->leftJoin('data_document', function ($join) {
            $join->on('user_reactive.docs_id', '=', 'data_document.docs_id');
        })
        ->leftJoin('data_types', function ($join) {
            $join->on('data_types.type_id', '=', 'data_document.type_id');
        })
        ->leftJoin('government', function ($join) {
            $join->on('government.government_id', '=', 'data_document.title_data');
        })->where('user_reactive.u_id' ,'=', auth()->user()->id)->where('user_reactive.reactive', '=', '1')->orderByDesc('reactive_at')->simplePaginate(10);
        return view('users.docsAll', compact('UserDocsAll'));
    }
    public function updateReactive(Request $request)
    {
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
        $reactive = DB::table('user_reactive')->where('docs_id', '=', $request->docs_id)->where('u_id','=',auth()->user()->id)->update([
            'reactive' => '1',
            'reactive_at' => now()
        ]);
       
        return redirect()->back()->with('success', "ลงรับหนังสือเรียบร้อย");
    }
}
