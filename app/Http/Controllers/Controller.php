<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use App\Http\Requests;

use Session;
use View;
use Input;
use Validator;
use Auth;
use Hash;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $controller = '';

	public $query = null;

	public $error_messages = [];

	public $query_fields = ['*'];

	public $excludes = [];

	public $primary_key = 'id';

	public $with_actions = true;

	public $response = [
		'success' => false,
		'data' => null,
		'errors' => []
	];

	public $fields = [
		'textareas' => [], 
		'dropdowns' => [], 
		'checkboxes' => [], 
		'dates' => [], 
		'text_replace' => [],
		'excludes' => [],
		'hiddens' => [],
		'times' => [],
	];

	/*
	* Replaces column value in the table
	*	$this->column_values = [
    *        'user_type' => [1 => 'Active', 0 => 'Inactive']
    *   ];
	*/ 
	public $column_values = [];

	/*
	* $relationships example usage
	* $this->relationships = [
	*   'product' => [
	*     'name' => 'Product Code',
	*     'column' => 'product_code'
	*    ]
	* ];
	*/
	public $relationships = [];

	public $filters = [
		'text'     => [],
		'checkbox' => [],
		'dropdown' => [],
	];

	public $view_path = null;

	public $rules = [];

	public function getController() {
		$regex = preg_match('/([a-z\_]+)\./', \Request::route()->getName(), $matches);

		if ($regex) {
			$this->controller = $matches[1];
			return view()->share('controller', $this->controller);
		}
	}

	public function index()
	{
		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);

		$model = new $namespace_model;

		if (!$this->query) {
			$this->query = $namespace_model::orderBy('id', 'DESC');

			if (isset($_GET['search']) && $_GET['search'] == true) {
				foreach ($_GET as $key => $value) {
					if ($key != 'search' && $value != "") {
						$this->query->orWhere($key, 'like', '%' . $value . '%');
					}
				}
			}

			$this->query = $this->query->paginate(20);
		}
		
		$this->columns = \Schema::getColumnListing(strtolower($controller));

		if ($this->query_fields[0] != '*') {

			$this->columns = array_intersect($this->query_fields, $this->columns);

		}

		if ($this->query) {

			$this->fields['hiddens'] = ['id'];

			return view('default/index')
			->with('data', $this->query)
			->with('columns', $this->columns)
			->with('column_values', $this->column_values)
			->with('primary_key', $this->primary_key)
			->with('fields', $this->fields)
			->with('excludes', isset($this->excludes) ? $this->excludes : [])
			->with('with_actions', $this->with_actions)
			->with('relationships', $this->relationships)
			->with('filters', $this->filters);

		}else{
			return back()->with($this->_response(false, "An error occured"));
		}

	}

	public function create()
	{	
		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);

		$model = new $namespace_model;

		$fillables = $model->getFillables();

		return view('default/create')
		->with('fillables', $fillables)
		->with('fields', $this->fields);
	}

	public function store(Request $request)
	{
		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);

		$rules = isset($namespace_model::$rules) ? $namespace_model::$rules : [];

		$data = $request->all();

		if (isset($data['password'])) {
			$data['password'] = Hash::make($data['password']);
		}

		$validate = Validator::make($data, $rules, $this->error_messages);


		if ($validate->fails()) {

			return back()->withErrors($validate)->withInput($request->all);

		}else{
			if ($namespace_model::create($data)) {
				return redirect($controller)->with($this->_response(true, "New ". str_replace('App\\', '', $namespace_model) ." successfuly added"));
			}
		}

	}

	public function edit($id)
	{
		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);

		$this->query = $namespace_model::find($id);

		if ($this->query) {
			$model = new $namespace_model;

			$fillables = $model->getFillables();

			$path = 'default/edit';

			if (isset($this->view_path)) {
				$path = $this->view_path;
			}

			return view($path)
			->with('data', $this->query)
			->with('fillables', $fillables)
			->with('fields', $this->fields)
			->with('primary_key', $this->primary_key);

		}else{
			return redirect($controller)->with($this->_response(false, "An error occured: Data is missing'"));
		}

	}

	public function show($id) {

		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);

		$this->query = $namespace_model::find($id);

		return $this->query;
	}

	public function update(Request $request, $id)
	{
		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);

		$this->query = $namespace_model::find($id);

		$data = $request->all();

		if ($this->query) {

			if (!$this->rules) {
				$this->rules = $namespace_model::$rules;
			}

			$validate = Validator::make($data, $this->rules);

			if ($validate->fails()) {
				return back()->withErrors($validate)->withInput($request->all);
			}else{
				
				if (isset($data['password'])) {
					$data['password'] = Hash::make($data['password']);
				}

				$this->query->fill($data);

				if ($this->query->save()) {
					return back()->with($this->_response(true, str_replace('App\\', '', $namespace_model)." updated successfully"));
				}
			}

		}else{
			return back()->with($this->_response(false, "An error occured"));
		}

	}

	public function destroy($id){

		$this->getController();

		$controller = $this->controller;

		$namespace_model = self::getModel($this->controller);
		$namespace_model::destroy($id);

		if (count($namespace_model::destroy($id))) {
			Session::flash('message', 'Item successfully deleted!');
			Session::flash('alert-class', 'alert-success'); 
		}else{
			Session::flash('message', 'An error occured');
			Session::flash('alert-class', 'alert-danger'); 
		}

		return back();

	}

	// Breaks controller name into pieces.
	// Example: teacher_question_table becomes TeacherQuestionTable
	public static function getModelName($controller){

		$new_controller = '';

		if (substr($controller, -2) == 'es' && $controller != 'codes') {
			$controller = substr($controller, 0, strlen($controller)-2);
		}else{
			$controller = substr($controller, 0, strlen($controller)-1);
		}

		$parts = explode('_', $controller);
		foreach ($parts as $key => $value) {
			$new_controller .= ucfirst($value);
		}

		return $new_controller;
	}

	public static function getModel($controller){

		return 'App\\' . self::getModelName($controller);

	}

	public function _response($success, $msg, $data = []) {
		return [
			'success' => $success,
			'message' => $msg,
			'data'    => $data
		];
	}
}
