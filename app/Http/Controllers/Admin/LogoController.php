<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LogoService;
use Illuminate\Support\Facades\Validator;

class LogoController extends Controller
{
    private $logoService;

    public function __construct(LogoService $logoService)
    {
        $this->logoService = $logoService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $logos = $this->logoService->paginate(10);
        return view('admin.logo.logo', compact('logos'));
    }

    public function all()
    {
        return $this->logoService->all();
    }
    
    public function store(Request $request)
    {   
        $request->validate([
            'email' => 'unique:logos',
            'number' => 'unique:logos'
        ]);

        $req = $request->all();

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        $logo = ($this->logoService->create($req))['logo']['logo'];
        
        if($request->dynamic){
            return $logo;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->logoService->find($_REQUEST['id']);
        }
        return $this->logoService->find($id);
    }
    
    public function update(Request $request, $id)
    {  
        $request->validate([
            'email' => 'unique:logos,email,'.$request->hidden,
            'number' => 'unique:logos,number,'.$request->hidden
        ]);

        $id = $request->hidden;
        $logo = ($this->show($id))['logo'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $logo->created_by){
            return redirect()->back();
        }

        $req = $request->all();

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        $logo = ($this->logoService->update($req, $id))['logo']['logo'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;
        
        $logo = ($this->show($id))['logo'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $logo->created_by){
            return redirect()->back();
        }

        $this->logoService->delete($id);

        return redirect()->back();
    }

    public function search_logos(Request $request)
    {
        $query = $request['query'];
        
        $logos = $this->logoService->search_logos($query);

        return view('admin.logo.logo', compact('logos'));
    }

    public function toggle_logo_status(Request $request)
    {
        if(!(isset($request['id']))){
            return '';
        }
        return $this->logoService->toggle_logo_status($request->id);
    }
}