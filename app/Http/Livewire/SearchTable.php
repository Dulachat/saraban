<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SearchTable extends Component
{
    public $searchTable;
    public function render()
    {
        $searchTable = '%'.$this->searchTable.'%';
        $user = DB::table('users')->where('docs_name','LIKE',$searchTable)
        ->orWhere('fname_TH','LIKE',$searchTable)
        ->orWhere('lname_TH','LIKE',$searchTable)
        ->orderByDesc('id')
        ->get();
        // $documentJoin = DB::table('data_document')
        // ->select('*')
        // ->leftJoin('government', function ($join) {
        //     $join->on('government.government_id', '=', 'data_document.title_data');
        // })
        // ->leftJoin('data_types', function ($join) {
        //     $join->on('data_types.type_id', '=', 'data_document.type_id');
        // })->where('docs_name','LIKE',$searchTable)
        // ->orWhere('government_name','LIKE',$searchTable)
        // ->orderByDesc('docs_id')
        // ->get();
        return view('admin.userMag',compact($user));
    }
}
