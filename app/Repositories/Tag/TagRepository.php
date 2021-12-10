<?php
namespace App\Repositories\Tag;

use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TagResource;


class TagRepository{

    public function getTags(){

        $tags = Tag::all();
        return (object)[
            'status'   => true,
            'data' => TagResource::collection($tags)
        ];
    }

    public function getTagById($id){

      $tag = Tag::find($id);
      if(!$tag){
        return (object)[
            'status'   => false,
            'msg'  => 'tag not found'
        ];
      }

      return (object)[
          'status'   => true,
          'data' => $tag
      ];

    }

    public function createTag($request){
        try{
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
            ];
            $tag = Tag::create($data);
            $tag->save();

            DB::commit();
            return (object)[
                'status'   => true,
                'msg'  => 'tag added successfully',
                'data' => $tag
            ];
        }catch (Exception $e){
            DB::rollback();
            return (object)[
                'status' => false,
                'msg' => 'something wrong happened'
            ];
        }

    }

    public function updateTag($id, $request){
        try{
                DB::beginTransaction();
                $data = [
                    'name' => $request->name,
                ];
                $tag = Tag::find($id);
                if(!$tag){
                  return (object)[
                      'status'   => false,
                      'msg'  => 'tag not found'
                  ];
                }
                //dd($data);
                $tag->update($data);
                DB::commit();

                return (object)[
                    'status'   => true,
                    'msg'  => 'tag updated successfully',
                    'data' => $tag
                ];
        }catch (Exception $e){
            DB::rollback();
            return (object)[
                'status'  => false,
                'msg' => 'something wrong happened'
            ];
        }
    }

    public function destroyTag($id){
        try {
          $tag = Tag::find($id);
            if(!$tag){
              return (object)[
                  'status'   => false,
                  'msg'  => 'tag not found'
              ];
            }
            if ($tag->delete()){
                $status  = true;
                $message = 'tag has been deleted successfully';
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
