<?php

namespace App\Repositories;

use App\Exceptions\Video\AllVideoException;
use App\Exceptions\Video\CreateVideoException;
use App\Exceptions\Video\UpdateVideoException;
use App\Exceptions\Video\DeleteVideoException;
use App\Models\Video;

abstract class VideoRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Video $video)
    {
        $this->model = $video;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $video = $this->model->create($data);
            
            return [
                'video' => $this->find($video->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find video',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'video' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteVideoException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find video',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'video' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateVideoException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $video = $this->model::find($id);
            if(!$video)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find video',
                ];
            }
            return [
                'success' => true,
                'video' => $video,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::all();
        }
        catch (\Exception $exception) {
            throw new AllVideoException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'ASC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllVideoException($exception->getMessage());
        }
    }

    public function search_videos($query)
    {
        // foreign fields

        // search block
        $videos = $this->model::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('link', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $videos;
    }
}