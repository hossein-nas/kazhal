<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{
        $allRootCategoryServices = Service::where('service_type', 'category')->where('parent_id', null)->with(['color', 'thumbnail'])->get();
        return view('home', compact('allRootCategoryServices'));
    }
}
