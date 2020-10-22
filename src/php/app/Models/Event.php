<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
	protected $fillable = [
		'start',
		'end',
		'title',
		'desc',
		'url',
		'callUrl',
	];

	protected $casts = [
		'start' => 'datetime',
		'end' => 'datetime',
		'title' => 'string',
		'desc' => 'string',
		'url' => 'string',
		'callUrl' => 'string',
	];
}
