<?php

namespace Allenjd3\Flywheel;

use Illuminate\Http\Response;
use JamesMoss\Flywheel\Document;

class FlywheelDocument extends Document {
	/**
	 * @return string
	 */
	public function __toString() {
		return json_encode($this);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return (array) $this;
	}
	/**
	 * @return Response
	 */
	public function toJson() {
		return Response::create($this)->header('Content-Type','application/json');
	}
}