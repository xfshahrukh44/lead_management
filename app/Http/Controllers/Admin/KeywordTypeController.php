<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KeywordTypeService;
use Illuminate\Support\Facades\Validator;

class KeywordTypeController extends Controller
{
    private $keywordTypeService;

    public function __construct(KeywordTypeService $keywordTypeService)
    {
        $this->keywordTypeService = $keywordTypeService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $keywordtypes = $this->keywordTypeService->paginate(10);
        return view('admin.keyword_type.keywordtype', compact('keywordtypes'));
    }

    public function all()
    {
        return $this->keywordTypeService->all();
    }
    
    public function store(Request $request)
    {
        $keywordtype = ($this->keywordTypeService->create($request->all()))['keywordtype']['keywordtype'];
        
        if($request->dynamic){
            return $keywordtype;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->keywordTypeService->find($_REQUEST['id']);
        }
        return $this->keywordTypeService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $keywordtype = ($this->show($id))['keywordtype'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $keywordtype->created_by){
            return redirect()->back();
        }
        // $request->validate([
        //     'name' => 'sometimes|string',
        // ]);

        $keywordtype = ($this->keywordTypeService->update($request->all(), $id))['keywordtype']['keywordtype'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;
        
        $keywordtype = ($this->show($id))['keywordtype'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $keywordtype->created_by){
            return redirect()->back();
        }

        $this->keywordTypeService->delete($id);

        return redirect()->back();
    }

    public function search_keywordtypes(Request $request)
    {
        $query = $request['query'];
        
        $keywordtypes = $this->keywordTypeService->search_keywordtypes($query);

        return view('admin.keyword_type.keywordtype', compact('keywordtypes'));
    }
}