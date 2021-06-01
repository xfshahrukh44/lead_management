<?php

namespace App\Repositories;

use App\Exceptions\Lead\AllLeadException;
use App\Exceptions\Lead\CreateLeadException;
use App\Exceptions\Lead\UpdateLeadException;
use App\Exceptions\Lead\DeleteLeadException;
use App\Models\Lead;

abstract class LeadRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Lead $lead)
    {
        $this->model = $lead;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $lead = $this->model->create($data);
            
            return [
                'lead' => $this->find($lead->id)
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
                    'message' => 'Could`nt find lead',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'lead' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteLeadException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find lead',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'lead' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateLeadException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $lead = $this->model::find($id);
            if(!$lead)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find lead',
                ];
            }
            return [
                'success' => true,
                'lead' => $lead,
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
            throw new AllLeadException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'ASC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllLeadException($exception->getMessage());
        }
    }

    public function search_leads($query)
    {
        // foreign fields

        // search block
        $leads = $this->model::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('link', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $leads;
    }
}