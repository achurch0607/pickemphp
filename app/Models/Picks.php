<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Picks extends Model
{
    use HasFactory;
    protected $table = 'nflp_picks';
    public $timestamps = false;
    protected $primaryKey = 'gameID';
    protected $fillable = ['gameID','userID', 'pickID', 'points'];
    
    public function insertPicks(request $request){
//       $input = Input::all();
       $input = $request->all();
       $userID = auth()->user()->id; 
       //DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
       
       foreach ($input as $k => $v) {
           if($k != '_token'){
               DB::insert('replace into nflp_picks (userID, gameID, pickID) values (?, ?, ?)', [$userID, $k, $v]);
           }

       }
       return true;
    }
    
    public function getcurrentUserPicks() {
        $userID = auth()->user()->id; 
        
        $allPicks = DB::table($this->table)->select('gameID', 'pickID')->where('userID', '=', $userID)->get();
        $userPicks = array();
        foreach($allPicks as $pick) {
            $userPicks[$pick->gameID] = $pick->pickID;
        }
        
        return $userPicks;
    }
   
   
}
