<?php

namespace Allenjd3\Flywheel;

use Carbon\Carbon;
use JamesMoss\Flywheel\Config;
use JamesMoss\Flywheel\Result;
use JamesMoss\Flywheel\Repository;


class FlywheelWrapper {

	protected $query;
	protected $repository;

	/**
	 * FlywheelWrapper constructor.
	 *
	 * @param string $name Similar to Table name
	 * @param string $path path to storage location
	 */
	public function __construct($name='posts', $path='../storage') {
		$this->config($name, $path);
	}

	/**
	 * @param string $name Similar to Table name
	 * @param string $path path to storage location
	 *
	 * @return $this
	 */
	public function config($name='posts', $path='../storage') {
		$config = new Config($path, array(
			'formatter' => new \JamesMoss\Flywheel\Formatter\Markdown,
			'query_class'    => FlywheelQuery::class,
			'document_class' => FlywheelDocument::class
		));
		$this->repository = new Repository($name, $config);
		$this->query = $this->repository->query();
		return $this;

	}
	/**
	 * @param $array  //key value pairs to store in document
	 * @param $timestamps|boolean add timestamps
	 *
	 * @return $id
	 */
	public function create($array, $timestamps = true) {

		if(isset($timestamps) && $timestamps == true){
			$now = Carbon::now();
			$array['created_at'] = $now;
			$array['updated_at'] = $now;
		}
		$doc = new FlywheelDocument($array);
		return $this->repository->store($doc);

	}
	/**
	 * Store a Document in the repository, but only if it already
	 * exists. The document must have an ID.
	 *
	 * @param FlywheelDocument $document The document to store
	 *
	 * @return bool True if stored, otherwise false
	 */
	public function update(FlywheelDocument $document)
	{
		return $this->repository->update($document);;
	}

	/**
	 * @return mixed
	 */
	public function findAll() {
		return $this->repository->findAll();
	}
	/**
	 * Returns a single document based on it's ID
	 *
	 * @param  string $id The ID of the document to find
	 *
	 * @return Document|boolean  The document if it exists, false if not.
	 */
	public function findById($id)
	{
		return $this->repository->findbyId($id);
	}
	/**
	 * Delete a document from the repository using its ID.
	 *
	 * @param mixed $id The ID of the document (or the document itself) to delete
	 *
	 * @return boolean True if deleted, false if not.
	 */
	public function delete($id)
	{
		return $this->repository->delete($id);
	}
	/**
	 * @param $val
	 * @param $sym
	 * @param $comp
	 *
	 * @return $this
	 */
	public function where($val, $sym, $comp) {
		$this->query->where($val, $sym, $comp);
		return $this;
	}

	/**
	 * @return Result
	 */
	public function get() {
		return $this->query->execute();
	}

	/**
	 * @return Result
	 */
	public function first() {
		$docs = $this->get();
		return $docs[0];
	}
	/**
	 * Set a limit on the number of documents returned. An offset from 0 can
	 * also be specified.
	 *
	 * @param int $count  The number of documents to return.
	 * @param int $offset The offset from which to return.
	 *
	 * @return FlywheelWrapper The same instance of this class.
	 */
	public function limit($count, $offset = 0)
	{
		$this->query->limit($count, $offset);

		return $this;
	}
	/**
	 * Sets the fields to order the results by. They should be in the
	 * the format 'fieldname ASC|DESC'. e.g 'dateAdded DESC'.
	 *
	 * @param mixed $fields An array comprising strings in the above format
	 *                      (or a single string)
	 *
	 * @return FlywheelWrapper The same instance of this class.
	 */
	public function orderBy($fields)
	{
		$this->query->orderBy($fields);

		return $this;
	}
	/**
	 * Adds a boolean AND predicate for this query,
	 *
	 * @param string|Closure $field    The name of the field to match or an anonymous
	 *                                 function that will define sub predicates.
	 * @param string         $operator An operator from the allowed list.
	 * @param string         $value    The value to compare against.
	 *
	 * @return FlywheelWrapper The same instance of this class.
	 */
	public function andWhere($field, $operator = null, $value = null)
	{
		$this->query->where($field, $operator, $value);

		return $this;
	}

}