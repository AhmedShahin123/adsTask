<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Ad;
use App\Repositories\Ad\AdRepository;
use Illuminate\Http\Request;
use Validator;

class AdController extends ApiController
{
    public $adRepo;
    public function __construct(AdRepository $adRepo){
        $this->adRepo = $adRepo;
        parent::__construct();
    }

    public function index(Request $request) {
        $ads = $this->adRepo->getAds([                      // pass category or tag or advertiser for filters ads
            'category' => $request->category,
            'tag' => $request->tag,
            'advertiser' => $request->advertiser,
        ]);
        return $ads;
    }

    public function show($id){
        $ad = $this->adRepo->getAdById($id);
        return $ad;
    }

    public function create(Request $request){

      $validator = Validator::make($request->all(),[
          'title' => 'required',
          'type' => 'required|in:free,paid',
          'description' => 'required',
          'start_date' => 'required',
          'advertiser_id' => 'required|integer|exists:users,id',
          'category_id' => 'required|integer|exists:categories,id',
          'tag_id' => 'required|exists:tags,id',
      ]);

        if($validator->fails())
              return response()->json(['status'=>false,'msg' => $validator->errors()->first()], 401);

        $ad = $this->adRepo->createAd( $request );
        return $ad;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'nullable',
            'type' => 'nullable|in:free,paid',
            'description' => 'nullable',
            'start_date' => 'nullable',
            'advertiser_id' => 'nullable|integer|exists:users,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'tag_id' => 'nullable|exists:tags,id',
        ]);

        if($validator->fails())
              return response()->json(['status'=>false,'msg' => $validator->errors()->first()], 401);

        $ad = $this->adRepo->updateAd($id, $request);
        return $ad;
    }

    public function destroy($id) {
        $ad = $this->adRepo->destroyAd($id);
        return $ad;
    }
}
