<?php

namespace App\Repositories;

use App\Exceptions\Keyword\AllKeywordException;
use App\Exceptions\Keyword\CreateKeywordException;
use App\Exceptions\Keyword\UpdateKeywordException;
use App\Exceptions\Keyword\DeleteKeywordException;
use App\Models\Keyword;

abstract class KeywordRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Keyword $keyword)
    {
        $this->model = $keyword;
    } 
    
    public function create(array $data)
    {
        try 
        {    
            $keyword = $this->model->create($data);
            
            return [
                'keyword' => $this->find($keyword->id)
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
                    'message' => 'Could`nt find keyword',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'keyword' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteKeywordException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find keyword',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'keyword' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateKeywordException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $keyword = $this->model::with('keyword_type')->find($id);
            if(!$keyword)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find keyword',
                ];
            }
            return [
                'success' => true,
                'keyword' => $keyword,
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
            throw new AllKeywordException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'ASC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllKeywordException($exception->getMessage());
        }
    }

    public function search_keywords($query)
    {
        // foreign fields

        // search block
        $keywords = $this->model::where('website_keyword', 'LIKE', '%'.$query.'%')
        ->orWhere('keyword_type', 'LIKE', '%'.$query.'%')
        ->paginate(env('PAGINATION'));

        return $keywords;
    }
}