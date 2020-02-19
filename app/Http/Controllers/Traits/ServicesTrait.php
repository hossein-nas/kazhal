<?php

namespace App\Http\Controllers\Traits;
use App\Service;

trait ServicesTrait {


	private function hasChildren($id){
		$services = Service::where('parent_id', $id )->get();
		if( $services->count() ){
			return true;
		}
		return false;
	}

	private function getChildren($id, $depth = 1){
		$services = Service::where('parent_id', $id )->with(['color', 'thumbnail'])->get(['id','title', 'slug','excerpt', 'service_type', 'parent_id', 'color_id','thumbnail_id']);
		$recursiveServices = [];
		foreach( $services as $item ) {
			$item->depth = $depth;
			$recursiveServices [] = $item;
			if($item->service_type == 'category' && $this->hasChildren($item->id) ){
				$recursiveServices = array_merge($recursiveServices, $this->getChildren($item->id, $depth+1) );
			}
		};
		return $recursiveServices;
	}
}