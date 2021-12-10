<?php

namespace App\Repositories\Ad;

use App\Models\Ad;
use App\Http\Resources\AdResource;
use App\Models\AdTranslation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AdRepository
{

    public function getAds($filter = [])
    {
        if ($filter) {
            $filter = (object)$filter;
        }
        $ads = Ad::with('tags')->latest('id');
        $params = [];


        if (isset($filter->category) && !empty($filter->category)) {
            $ads = $ads->whereHas('category', function ($q) use ($filter) {
                $q->where('id', $filter->category);
            });
        }
        if (isset($filter->tag) && !empty($filter->tag)) {
            $ads = $ads->whereHas('tags', function ($q) use ($filter) {
                $q->where('tags.id', $filter->tag);
            });
        }

        if (isset($filter->advertiser) && !empty($filter->advertiser)) {
            $ads = $ads->where('advertiser_id', $filter->advertiser);
        }

        return [
            'status'   => true,
            'data' => AdResource::collection($ads->get())
        ];
    }

    public function getAdById($id) {
        $ad = Ad::where('id', $id)->first();

        if(!$ad){
          return (object)[
          'status'   => false,
          'msg'  => 'ad not found'
           ];
        }

        return [
            'status'   => true,
            'data' => new AdResource($ad)
        ];
    }

    public function createAd($request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'title'   => $request->title,
                'advertiser_id'   => $request->advertiser_id,
                'type'      => $request->type,
                'description'     => $request->description,
                'start_date'  => Carbon::parse($request->start_date)->format('Y-m-d'),
                'category_id'    => $request->category_id,
            ];

            $ad = Ad::create($data);
            $ad->save();
            $ad->tags()->attach($request->tag_id); // add tags for ad

            DB::commit();
            return (object)[
                'status' => true,
                'message' => 'Ad created successfully',
                'ad' => new AdResource($ad),
            ];
        } catch (Exception $e) {
            DB::rollback();
            return (object)[
                'status' => false,
                'message' => 'Something wrong happened'
            ];
        }
    }

    public function updateAd($id, $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $ad = Ad::find($id);

            if(!$ad){
              return (object)[
                  'status'   => false,
                  'msg'  => 'ad not found'
              ];
            }

            if ($request->start_date) {
                $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
            }

            $ad->update($data);
            DB::commit();
            return (object)[
                'status' => true,
                'message' => 'Ad updated successfully',
                'ad' => new AdResource($ad)
            ];
        } catch (Exception $e) {
            DB::rollback();
            return (object)[
                'status' => false,
                'message' => 'something wrong happened'
            ];
        }
    }

    public function destroyAd($id){
        try {
          $ad = Ad::find($id);
            if(!$ad){
              return (object)[
                  'status'   => false,
                  'msg'  => 'ad not found'
              ];
            }
            if ($ad->delete()){
                $status  = true;
                $message = 'ad has been deleted successfully';
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
