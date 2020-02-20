<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\ServicesTrait;

class ServicesController extends Controller
{
	use ServicesTrait;

	protected $attrs;
	protected $params;
	protected $resp;
	protected $model;

	public function index($slug)
	{
		$service = Service::where('slug', $slug)->with(['color', 'thumbnail'])->first();
		if($service->service_type == 'category' && $this->hasChildren($service->id) ){
			$service->hasChild = true;
			$service->children = Service::where('parent_id', $service->id)->with(['color', 'thumbnail'])->get();
		}
		return view('Services.single', compact('service'));
	}

	public function getAllServices()
	{
		$allServices = Service::all();
	}

	public function getSingleService(Request $request, $id)
	{
		$service = Service::with(['thumbnail'])->find($id);
		return $service;
	}

	public function getRecursiveServices()
	{
		return $this->getChildren(null);
	}

	public function deleteService(Request $request)
	{
		$id = $request->get('service_id');
		$service = Service::find($id);

		// checking for having child
		if( $this->hasChildren($service->id)){
			return response()->json([
				'status' 		=> 'error',
				'text'			=> 'failed_to_delete_service',
				'message'		=> 'سرویس مورد نظر دارای زیرسرویس است.',
				'data'			=> null,
			]);
		}

		$service->delete();
		return response()->json([
			'status' 		=> 'ok',
			'text'			=> 'successfully_deleted',
			'message'		=> 'سرویس مورد نظر با موفقیت حذف گردید.',
			'data'			=> null,
		]);
	}

	public function getAllCategoryServices()
	{
		$all = Service::where('service_type', 'category')->get(['title','id','parent_id']);
		return $all;
	}

	public function addNew(Request $request)
	{
		$this->params = $request->all();
		if(!$this->validateParams()){
			return response()->json($this->resp);
		}

		$this->persistOnDB();
		return response()->json($this->resp);
	}

	private function validateParams()
	{
		$validate = Validator::make($this->params,[
			'title' 				=> 'required|min:10',
			'slug' 					=> 'required|min:10',
			'content' 				=> 'required|min:50',
			'excerpt' 				=> 'required|min:25',
			'service_type' 			=> 'required',
			'parent_id' 			=> 'nullable|numeric',
			'price'		 			=> 'nullable',
			'features' 				=> 'array',
			'hardware' 				=> 'array',
			'extra' 				=> 'array',
			'thumbnail_id' 			=> 'required|numeric',
			'color_id' 				=> 'required|numeric',
		]);

		if( $validate->fails()){
			$this->resp = [
				'status' 		=> 'error',
				'text'			=> 'adding_new_service_failed',
				'message'		=> 'خطایی در ثبت سرویس جدید رخ داد.',
				'data'			=> $validate->errors()
			];
			return false;
		}

		$this->attrs = $validate->validated();
		return true;
	}

	private function persistOnDB()
	{
		$service = new \App\Service();
		$service->fill($this->attrs)->save();
		$this->model = $service;

		$this->makeResponse();
	}

	private function makeResponse()
	{
		$this->resp = [
			'status' 		=> 'ok',
			'text'			=> 'service_added_successfully',
			'message'		=> 'سرویس با موفقیت افزوده شد.',
			'data' 			=> $this->model,
		];
	}
}
