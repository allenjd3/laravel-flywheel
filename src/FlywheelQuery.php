<?php

namespace Allenjd3\Flywheel;

use JamesMoss\Flywheel\Query;

class FlywheelQuery extends Query {

	public function execute()
	{
		$qe = new FlywheelQueryExecuter($this->repo, $this->predicate, $this->limit, $this->orderBy);

		return $qe->run();
	}
}