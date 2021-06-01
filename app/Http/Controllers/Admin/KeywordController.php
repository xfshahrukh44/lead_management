<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\KeywordService;
use Illuminate\Support\Facades\Validator;
use App\Models\KeywordType;

class KeywordController extends Controller
{
    private $keywordService;

    public function __construct(KeywordService $keywordService)
    {
        $this->keywordService = $keywordService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $keywordtypes = KeywordType::all();
        $keywords = $this->keywordService->paginate(10);
        return view('admin.keyword.keyword', compact('keywords','keywordtypes'));
    }

    public function all()
    {
        return $this->keywordService->all();
    }
    
    public function store(Request $request)
    {
        $keyword = ($this->keywordService->create($request->all()))['keyword']['keyword'];
        
        if($request->dynamic){
            return $keyword;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->keywordService->find($_REQUEST['id']);
        }
        return $this->keywordService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $keyword = ($this->show($id))['keyword'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $keyword->created_by){
            return redirect()->back();
        }
        // $request->validate([
        //     'name' => 'sometimes|string',
        // ]);

        $keyword = ($this->keywordService->update($request->all(), $id))['keyword']['keyword'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;
        
        $keyword = ($this->show($id))['keyword'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $keyword->created_by){
            return redirect()->back();
        }

        $this->keywordService->delete($id);

        return redirect()->back();
    }

    public function search_keywords(Request $request)
    {
        $query = $request['query'];
        
        $keywords = $this->keywordService->search_keywords($query);

        return view('admin.keyword.keyword', compact('keywords'));
    }
}