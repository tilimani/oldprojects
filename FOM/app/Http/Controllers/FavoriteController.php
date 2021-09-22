<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\User;
use App\House;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SegmentController as Analytics;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
  public function store(Request $request)
  {
    $users_favorites=DB::table('favorites')
    ->where('house_id',$request->house_id)
    ->where('user_id',$request->user_id)
    ->first();
    if (!$users_favorites) {
      try {
        DB::beginTransaction();
        $favorite= new Favorite();
        $favorite->user_id=$request->user_id;
        $favorite->house_id=$request->house_id;
        $favorite->save();
        DB::commit();

        // SEGMENT TRACKING INIT-------------------
        if (env('APP_ENV')=='production' && Auth::user()->role_id!=1) {

          $house = House::find($request->house_id);
          $user = User::find($request->user_id);
          Analytics::addHouseToFavorites($user,$house);

        }
        // SEGMENT TRACKING END-------------------
        return 1;

      } catch (\Exception $e) {
          DB::rollBack();
          return $e;
      }

    }
    else{
      return 0;
    }
  }



  public function getFavoritesUser(User $user)
  {
    $query = DB::table('houses')->join('rooms','rooms.house_id','=','houses.id');
    $query = DB::table('houses')->join('neighborhoods', 'neighborhoods.id', '=', 'houses.neighborhood_id');
    $query = DB::table('houses')->join('managers','managers.id','=','houses.manager_id');
    $query = $query->where('houses.status', '=', 1);
    $query = $query->orderBy('managers.vip', 'desc');
    $users_favorites =$query->select('managers.vip','houses.id','houses.name','houses.address', 'houses.status' , 'houses.rooms_quantity',
    DB::raw("(SELECT MIN(rooms.price) FROM rooms WHERE rooms.house_id = houses.id) as min_price"),
    DB::raw("(SELECT COUNT(rooms.house_id) FROM rooms WHERE rooms.house_id = houses.id AND rooms.available_from <= now()) as available_rooms"),
    DB::raw("(SELECT MIN(rooms.available_from) FROM rooms WHERE rooms.house_id = houses.id) as min_date"),
    DB::raw("(SELECT name FROM neighborhoods WHERE neighborhoods.id = houses.neighborhood_id) as neighborhood_name"))
    ->groupBy(['managers.vip','houses.id', 'houses.name', 'houses.address', 'houses.neighborhood_id'])
    ->join('favorites','house_id','=','houses.id')
    ->where('favorites.user_id',$user->id)
    ->orderBy('houses.id','desc')
    ->get();

    foreach ($users_favorites as $favorite) {
      $favorite->main_image = DB::table('image_houses')
        ->select('priority','house_id', 'image')
        ->orderBy('image_houses.priority','asc')
        ->where('house_id','=',$favorite->id)
        ->get();
        if(sizeof($favorite->main_image) == 0){
          $dummy_image=['priority'=>'0','house_id'=>$favorite->id,'image'=>'room_4.jpeg'];
          $dummy_image=(object) $dummy_image;
          for($i=0;$i<5;$i++){
            // $favorite->main_image.push($dummy_image);
          }
        }
    }

    return view('houses.favorites',[
      'users_favorites'=>$users_favorites,
      'today_30' => Carbon::now()->addWeeks(4),
      'today' => Carbon::now()
    ]);

  }


  public function deleteFavorite(Request $request)
  {
    try {
      DB::beginTransaction();

      $users_favorites = DB::table('favorites')
      ->where('user_id','=', $request->user_id)
      ->where('house_id','=', $request->house_id)
      ->delete();

      DB::commit();
      // SEGMENT TRACKING INIT-------------------
      if (env('APP_ENV')=='production' && Auth::user()->role_id!=1) {
        $house = House::find($request->house_id);
        $user = User::find($request->user_id);

        Analytics::removeHouseFromFavorites($user, $house);
      }
      // SEGMENT TRACKING END-------------------

      return 1;
    } catch (\Exception $e) {

      DB::rollBack();
      return $e;

    }
  }
}
