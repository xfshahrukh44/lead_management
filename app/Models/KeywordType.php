<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KeywordType extends Model
{
	use HasFactory;
	use SoftDeletes;

	protected $fillable=['keyword_name'];

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
