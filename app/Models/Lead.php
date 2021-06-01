<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'date',
        'name',
        'location',
        'email',
        'number',
        'lead_from',
        'assigned_to',
        'website',
        'platform',
        'keyword',
        'profile_link',
        'query',
        'created_by',
        'modified_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = (auth()->user()) ? (auth()->user()->id) : NULL;
        });

        static::updating(function ($query) {
            $query->modified_by = (auth()->user()) ? (auth()->user()->id) : NULL;
        });

        static::deleting(function ($query) {
            
        });

        static::created(function ($query) {
            
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }
}