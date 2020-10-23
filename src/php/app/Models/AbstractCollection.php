<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractCollection extends Collection {
	/**
	 * @var string
	 */
	public const MODEL = Model::class;
}
