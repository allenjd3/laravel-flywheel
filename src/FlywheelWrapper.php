<?php


namespace Allenjd3\Flywheel;

use JamesMoss\Flywheel\Config;
use JamesMoss\Flywheel\Document;
use JamesMoss\Flywheel\Repository;
use JamesMoss\Flywheel\Formatter\Markdown;

class FlywheelWrapper {

	protected $query;
	protected $config;
	protected $repository;
	protected $markdownParse;

	/**
	 * FlywheelWrapper constructor.
	 *
	 * @param string $table
	 * @param null $path
	 */
	public function __construct($table='posts', $path= null) {

		$this->config($table,$path);

	}

	/**
	 * @param string $table
	 * @param null $path
	 *
	 * @return $this
	 */
	public function config($table = 'posts', $path = null) {
		if ( isset( $path ) ) {
			$this->config = new Config( $path, array(
				'formatter' => new Markdown
			) );
		} else {
			$this->config = new Config( '../storage/app/public/', array(
				'formatter' => new Markdown
			) );
		}
		$this->repository = new Repository($table, $this->config);
		$this->markdownParse = new GithubMarkdown();
		$this->markdownParse->html5 = true;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function findAll() {
		$docs = collect($this->repository->findAll());
		foreach($docs as $doc) {
			$doc->body = $this->markdownParse->parse($doc->body);
		}
		return $docs;
	}

	/**
	 * @param $array
	 *
	 * @return mixed
	 */
	public function create($array, $slug = null) {

		$document = new Document($array);
		if(isset($slug)){
			$document->setId($slug);
		}
		return $this->repository->store($document);
	}

	/**
	 * @param $var
	 * @param $sym
	 * @param $comp
	 *
	 * @return $this
	 */
	public function where($var, $sym, $comp) {

		$this->query = $this->repository->query()->where($var,$sym,$comp);
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function get() {

		$response = collect($this->query->execute());

		foreach ($response as $r) {
			$r->body = $this->markdownParse->parse($r->body);
		}
		return $response;
	}

}