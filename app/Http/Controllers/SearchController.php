<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SearchController extends Controller
{
   public function index()
{
return view('search.search');
}
public function search(Request $request)
{
if($request->ajax())
{
$output="";
$products=DB::table('data_document')->where('docs_name','LIKE','%'.$request->search."%")->get();
if($products)
{
foreach ($products as $key => $product) {
$output.='<tr>'.
'<td>'.$product->id.'</td>'.
'<td>'.$product->docs_name.'</td>'.
'</tr>';
}
return Response($output);
   }
   }
}
}