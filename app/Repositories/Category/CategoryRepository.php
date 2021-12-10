<?php
namespace App\Repositories\Category;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryCreateRequest;

class CategoryRepository{

    public function getCategories(){

        $categories = Category::all();
        return (object)[
            'status'   => true,
            'data' => CategoryResource::collection($categories)
        ];
    }

    public function getCategoryById($id){

      $category = Category::find($id);
      if(!$category){
        return (object)[
            'status'   => false,
            'msg'  => 'category not found'
        ];
      }

      return (object)[
          'status'   => true,
          'data' => $category
      ];

    }

    public function createCategory($request){
        try{
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
            ];
            $category = Category::create($data);
            $category->save();

            DB::commit();
            return (object)[
                'status'   => true,
                'msg'  => 'category added successfully',
                'data' => $category
            ];
        }catch (Exception $e){
            DB::rollback();
            return (object)[
                'status' => false,
                'msg' => 'something wrong happened'
            ];
        }

    }

    public function updateCategory($id, $request){
        try{
                DB::beginTransaction();
                $data = [
                    'name' => $request->name,
                ];
                $category = Category::find($id);
                if(!$category){
                  return (object)[
                      'status'   => false,
                      'msg'  => 'category not found'
                  ];
                }
                $category->update($data);
                DB::commit();

            return (object)[
                'status'   => true,
                'msg'  => 'category updated successfully',
                'data' => $category
            ];
        }catch (Exception $e){
            DB::rollback();
            return (object)[
                'status'  => false,
                'msg' => 'something wrong happened'
            ];
        }
    }

    public function destroyCategory($id){
        try {
          $category = Category::find($id);
            if(!$category){
              return (object)[
                  'status'   => false,
                  'msg'  => 'category not found'
              ];
            }
            if ($category->delete()){
                $status  = true;
                $message = 'category has been deleted successfully';
            }
            return (object)[
                'status'  => $status,
                'msg' => $message
            ];
        }catch (Exception $e){
            return (object)[
                'status'  => false,
                'msg' => 'something wrong happened'
            ];
        }
    }


}
