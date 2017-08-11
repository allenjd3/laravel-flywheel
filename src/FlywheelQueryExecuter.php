<?php

namespace Allenjd3\Flywheel;

use JamesMoss\Flywheel\QueryExecuter;

class FlywheelQueryExecuter extends QueryExecuter {
	/**
	 * Runs the query.
	 *
	 * @return Result The documents returned from this query.
	 */
	public function run()
	{
		$documents = $this->repo->findAll();

		if ($predicates = $this->predicate->getAll()) {
			$documents = $this->filter($documents, $predicates);
		}

		if ($this->orderBy) {
			$sorts = array();
			foreach ($this->orderBy as $order) {
				$parts = explode(' ', $order, 2);
				// TODO - validate parts
				$sorts[] = array(
					$parts[0],
					isset($parts[1]) && $parts[1] == 'DESC' ? SORT_DESC : SORT_ASC
				);
			}

			$documents = $this->sort($documents, $sorts);
		}

		$totalCount = count($documents);

		if ($this->limit) {
			list($count, $offset) = $this->limit;
			$documents = array_slice($documents, $offset, $count);
		}

		return new FlywheelResult(array_values($documents), $totalCount);
	}
}