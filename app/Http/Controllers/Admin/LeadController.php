<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LeadService;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    private $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $leads = $this->leadService->paginate(10);
        return view('admin.lead.lead', compact('leads'));
    }

    public function all()
    {
        return $this->leadService->all();
    }
    
    public function store(Request $request)
    {   
        $request->validate([
            'email' => 'unique:leads',
            'number' => 'unique:leads'
        ]);

        $lead = ($this->leadService->create($request->all()))['lead']['lead'];
        
        if($request->dynamic){
            return $lead;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->leadService->find($_REQUEST['id']);
        }
        return $this->leadService->find($id);
    }
    
    public function update(Request $request, $id)
    {  
        $request->validate([
            'email' => 'unique:leads,email,'.$request->hidden,
            'number' => 'unique:leads,number,'.$request->hidden
        ]);

        $id = $request->hidden;
        $lead = ($this->show($id))['lead'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $lead->created_by){
            return redirect()->back();
        }
        // $request->validate([
        //     'name' => 'sometimes|string',
        // ]);

        $lead = ($this->leadService->update($request->all(), $id))['lead']['lead'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;
        
        $lead = ($this->show($id))['lead'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $lead->created_by){
            return redirect()->back();
        }

        $this->leadService->delete($id);

        return redirect()->back();
    }

    public function search_leads(Request $request)
    {
        $query = $request['query'];
        
        $leads = $this->leadService->search_leads($query);

        return view('admin.lead.lead', compact('leads'));
    }
}