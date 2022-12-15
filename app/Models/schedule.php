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
        $currentSchedule = DB::table('nflp_schedule')
            ->join('nflp_picks', 'nflp_schedule.gameID', '=', 'nflp_picks.gameID')
//            ->where("nflp_picks.userID", "=", $userID)
            ->get(); 
        
        return $currentSchedule;
        
    }
    
    public function getCurrentWeek() {
	//get the current week number
        global $mysqli;
        $sql = "select distinct weekNum from " . DB_PREFIX . "schedule where DATE_ADD(NOW(), INTERVAL " . SERVER_TIMEZONE_OFFSET . " HOUR) < gameTimeEastern order by weekNum limit 1";
        $query = $mysqli->query($sql);
        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            return $row['weekNum'];
        } else {
            $sql = "select max(weekNum) as weekNum from " . DB_PREFIX . "schedule";
            $query2 = $mysqli->query($sql);
            if ($query2->num_rows > 0) {
                $row = $query2->fetch_assoc();
                return $row['weekNum'];
            }
            $query2->free;
        }
        $query->free;
        die('Error getting current week: ' . $mysqli->error);
    }

    public function getCutoffDateTime($week) {
        //get the cutoff date for a given week
        global $mysqli;
        $sql = "select gameTimeEastern from " . DB_PREFIX . "schedule where weekNum = " . $week . " and DATE_FORMAT(gameTimeEastern, '%W') = 'Sunday' order by gameTimeEastern limit 1;";
        $query = $mysqli->query($sql);
        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            return $row['gameTimeEastern'];
        }
        $query->free;
        die('Error getting cutoff date: ' . $mysqli->error);
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
