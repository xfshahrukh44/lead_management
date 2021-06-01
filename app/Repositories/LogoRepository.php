<?php

namespace App\Repositories;

use App\Exceptions\Logo\AllLogoException;
use App\Exceptions\Logo\CreateLogoException;
use App\Exceptions\Logo\UpdateLogoException;
use App\Exceptions\Logo\DeleteLogoException;
use App\Models\Logo;

abstract class LogoRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Logo $logo)
    {
        $this->model = $logo;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $logo = $this->model->create($data);
            
            return [
                'logo' => $this->find($logo->id)
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
                    'message' => 'Could`nt find logo',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'logo' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteLogoException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find logo',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'logo' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateLogoException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $logo = $this->model::find($id);
            if(!$logo)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find logo',
                ];
            }
            return [
                'success' => true,
                'logo' => $logo,
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
            throw new AllLogoException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'ASC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllLogoException($exception->getMessage());
        }
    }

    public function search_logos($query)
    {
        // foreign fields

        // search block
        $logos = $this->model::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('link', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $logos;
    }
}