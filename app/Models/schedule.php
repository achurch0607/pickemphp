<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class schedule extends Model
{
    use HasFactory;
    protected $table = 'nflp_schedule';
    public $timestamps = false;
    protected $primaryKey = 'gameID';
    protected $fillable = ['gameID','weekNum', 'gameTimeEastern', 'homeID', 'homeScore', 'visitorID', 'visitorScore', 'overtime' ];
    

    public function getWeekSchedule($week){
        //if no week passed in set week to current week

        $userID = auth()->user()->id;
        $currentSchedule = DB::table('nflp_schedule')->where('weekNum','=',$week)->orderBy('gameTimeEastern', 'asc')->get(); 
        return $currentSchedule;
        
    }
    
    public function getCurrentWeek() {
	//get the current week number
        $offset = config('constants.options.SERVER_TIMEZONE_OFFSET');
        $results = DB::select("SELECT DISTINCT weekNum from $this->table WHERE DATE_ADD(NOW(), INTERVAL $offset HOUR) < gameTimeEastern order by weekNum limit 1");
        if( count($results) > 0) {
           return  $results[0]->weekNum;
        } else {
            $sql = DB::select("select max(weekNum) as weekNum from $this->table");
            return $sql[0]->weekNum;
        }
    }
    
    /*
     * @return gameID of games before current time. expired games that can not be selected
     */
    public function getExpiredGames($week) {
        $offset = config('constants.options.SERVER_TIMEZONE_OFFSET');
//        $cutoffDateTime = $this->getCutoffDateTime($week);
//        $sql = "select * from " . DB_PREFIX . "schedule where weekNum = " . $_POST['week'] . " and (DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < gameTimeEastern and DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < '" . $cutoffDateTime . "');";
        $sql =  DB::select("select gameID from $this->table where weekNum = $week and (DATE_ADD(NOW(), INTERVAL $offset HOUR) > gameTimeEastern)");
        $expired = array();
         foreach($sql as $gID) {
            array_push($expired, $gID->gameID);
        }
//        dd($expired);
        return $expired;
        
    }

    public function getCutoffDateTime($week) {
        //get the cutoff date for a given week
        
        $sql = DB::select("SELECT gameTimeEastern FROM $this->table WHERE weekNum = " . $week . " and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1");
//        dd($sql);
        return $sql[0]->gameTimeEastern;
        
        
    }

    public function getFirstGameTime($week) {
        //get the first game time for a given week
        global $mysqli;
        $sql = "select gameTimeEastern from " . DB_PREFIX . "schedule where weekNum = " . $week . " order by gameTimeEastern limit 1";
        $query = $mysqli->query($sql);
        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            return $row['gameTimeEastern'];
        }
        $query->free;
        die('Error getting first game time: ' . $mysqli->error);
    }

    /*
     * `gameID` int(11) NOT NULL AUTO_INCREMENT,
  `weekNum` int(11) NOT NULL,
  `gameTimeEastern` datetime DEFAULT NULL,
  `homeID` varchar(10) NOT NULL,
  `homeScore` int(11) DEFAULT NULL,
  `visitorID` varchar(10) NOT NULL,
  `visitorScore` int(11) DEFAULT NULL,
  `overtime` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gameID`),
  KEY `GameID` (`gameID`),
  KEY `HomeID` (`homeID`),
  KEY `VisitorID` (`visitorID`)
     */
}
