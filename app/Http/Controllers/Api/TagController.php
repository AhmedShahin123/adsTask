<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Tag\TagRepository;

use Illuminate\Http\Request;
use Validator;

class TagController extends ApiController
{

    public $tagRepo;
    public function __construct(TagRepository $tagRepo){
        $this->tagRepo = $tagRepo;
        parent::__construct();
    }

    public function index(){

        return $this->tagRepo->getTags();

    }

    public function create(Request $request){

      $validator = Validator::make($request->all(),[
          'name' => 'required',
      ]);

        if($validator->fails())
              return response()->json(['status'=>false,'msg' => $validator->errors()->first()], 401);

        $tag = $this->tagRepo->createTag( $request );
        return $tag;
    }

    public function update(Request $request, $id)
    {
        $tag = $this->tagRepo->updateTag($id, $request);
        return $tag;
    }

    public function show($id)
    {
      $tag = $this->tagRepo->getTagById($id);
      return $tag;
    }

    public function destroy($id) {
        $tag = $this->tagRepo->destroyTag($id);
        return $tag;
    }
}
