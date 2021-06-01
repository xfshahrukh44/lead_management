<?php

namespace App\Repositories;

use App\Exceptions\KeywordType\AllKeywordTypeException;
use App\Exceptions\KeywordType\CreateKeywordTypeException;
use App\Exceptions\KeywordType\UpdateKeywordTypeException;
use App\Exceptions\KeywordType\DeleteKeywordTypeException;
use App\Models\KeywordType;

abstract class KeywordTypeRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(KeywordType $keywordtype)
    {
        $this->model = $keywordtype;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $keywordtype = $this->model->create($data);
            
            return [
                'keywordtype' => $this->find($keywordtype->id)
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
                    'message' => 'Could`nt find keywordtype',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'keywordtype' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteKeywordTypeException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find keywordtype',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'keywordtype' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateKeywordTypeException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $keywordtype = $this->model::find($id);
            if(!$keywordtype)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find keywordtype',
                ];
            }
            return [
                'success' => true,
                'keywordtype' => $keywordtype,
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
            throw new AllKeywordTypeException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'ASC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllKeywordTypeException($exception->getMessage());
        }
    }

    public function search_keywordtypes($query)
    {
        // foreign fields

        // search block
        $keywordtypes = $this->model::where('keyword_name', 'LIKE', '%'.$query.'%')
        ->paginate(env('PAGINATION'));

        return $keywordtypes;
    }
}