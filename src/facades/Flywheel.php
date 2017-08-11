<?php

namespace Allenjd3\Flywheel\facades;

use Illuminate\Support\Facades\Facade;

class Flywheel extends Facade {
	/**
	 * Get the binding in the IoC container
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'Flywheel';
	}
}