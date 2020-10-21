<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'start',
		'end',
		'title',
		'desc',
		'url',
		'callUrl',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];
}
