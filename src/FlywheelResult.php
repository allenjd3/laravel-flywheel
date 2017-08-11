<?php

namespace Allenjd3\Flywheel;

use Illuminate\Http\Response;
use JamesMoss\Flywheel\Result;

class FlywheelResult extends Result {
	/**
	 * @return string
	 */
	public function __toString() {
		return json_encode($this->documents);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return (array) $this->documents;
	}

	/**
	 * @return Response
	 */
	public function toJson() {
		return Response::create($this->documents)->header('Content-Type', 'application/json');
	}
}