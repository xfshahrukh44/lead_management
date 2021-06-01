<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VideoService;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    private $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $videos = $this->videoService->paginate(10);
        return view('admin.video.video', compact('videos'));
    }

    public function all()
    {
        return $this->videoService->all();
    }
    
    public function store(Request $request)
    {   
        $request->validate([
            'email' => 'unique:videos',
            'number' => 'unique:videos'
        ]);

        $req = $request->all();

        // status work
        if(isset($request['status'])){
            $req['status'] = 'Active';
        }
        else{
            $req['status'] = 'Inactive';
        }

        $video = ($this->videoService->create($req))['video']['video'];
        
        if($request->dynamic){
            return $video;
        }
        else{
            return redirect()->back();
        }
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->videoService->find($_REQUEST['id']);
        }
        return $this->videoService->find($id);
    }
    
    public function update(Request $request, $id)
    {  
        $request->validate([
            'email' => 'unique:videos,email,'.$request->hidden,
            'number' => 'unique:videos,number,'.$request->hidden
        ]);

        $id = $request->hidden;
        $video = ($this->show($id))['video'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $video->created_by){
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

        $video = ($this->videoService->update($req, $id))['video']['video'];

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;
        
        $video = ($this->show($id))['video'];
        
        if(auth()->user()->type != 'Manager' && auth()->user()->type != 'Admin' && auth()->user()->id != $video->created_by){
            return redirect()->back();
        }

        $this->videoService->delete($id);

        return redirect()->back();
    }

    public function search_videos(Request $request)
    {
        $query = $request['query'];
        
        $videos = $this->videoService->search_videos($query);

        return view('admin.video.video', compact('videos'));
    }

    public function toggle_video_status(Request $request)
    {
        if(!(isset($request['id']))){
            return '';
        }
        return $this->videoService->toggle_video_status($request->id);
    }
}