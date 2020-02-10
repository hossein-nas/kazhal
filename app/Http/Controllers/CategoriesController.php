<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function getAllCats(){
        $root_cats = Category::where('parent_id', null)->get();
        $this->addChildren($root_cats);
        if( request()->ajax()){
            return response()->json($root_cats->toArray());
        }
        return $root_cats;
    }

    public function getChildren($cat)
    {
        $id = $cat->id;
        $child_cats = Category::where('parent_id', $id)->get();
        if( $child_cats->count() ){
            return $child_cats;
        }
        return null;
    }

    public function addChildren(&$cats, $depth = 0)
    {
        foreach ($cats as &$cat ){
            $child = $this->getChildren($cat);
            $this->adddepth($cats, $depth);
            if( $child != null ){
                $this->addChildren($child, $depth + 1);
                $cat->children = $child;
            }
        }
    }

    public function addDepth(&$cats, $depth = 0)
    {
        foreach( $cats as &$cat){
            $cat->depth = $depth;
        }
    }

    public function addNew(Request $request){
        $validate = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        if( $validate->fails() ){
            return response()->json([
                'status' => 'error',
                'text' => 'add_new_category_failed',
                'message' => 'خطایی در پارامتر‌های ارسالی وجود دارد',
                'data' => null,
            ]);
        }

        Category::create($request->all());
        return response()->json([
                'status' => 'ok',
                'text' => 'successfully_added',
                'message' => 'با موفقیت افزوده شد.',
                'data' => null,
        ]);
    }
}
