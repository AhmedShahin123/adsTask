<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepository;

use Illuminate\Http\Request;
use Validator;

class CategoryController extends ApiController
{

    public $categoryRepo;
    public function __construct(CategoryRepository $categoryRepo){
        $this->categoryRepo = $categoryRepo;
        parent::__construct();
    }

    public function index(){

        return $this->categoryRepo->getCategories();

    }

    public function create(Request $request){

      $validator = Validator::make($request->all(),[
          'name' => 'required',
      ]);

        if($validator->fails())
              return response()->json(['status'=>false,'msg' => $validator->errors()->first()], 401);

        $category = $this->categoryRepo->createCategory( $request );
        return $category;
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryRepo->updateCategory($id, $request);
        return $category;
    }

    public function show($id)
    {
      $category = $this->categoryRepo->getCategoryById($id);
      return $category;
    }

    public function destroy($id) {
        $category = $this->categoryRepo->destroyCategory($id);
        return $category;
    }
}
