<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teams;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TeamsController extends Controller
{
    public function __construct() {
        

    }
    
    public function index(Request $request) {
//        $teams = Teams::all();
        $teams = DB::table('nflp_teams')->get();
        
        return view('teams', compact('teams'));
    }
    
            
//            DROP TABLE IF EXISTS `nflp_teams`;
//CREATE TABLE `nflp_teams` (
//  `teamID` varchar(10) NOT NULL,
//  `divisionID` int(11) NOT NULL,
//  `city` varchar(50) DEFAULT NULL,
//  `team` varchar(50) DEFAULT NULL,
//  `displayName` varchar(50) DEFAULT NULL,
//  PRIMARY KEY (`teamID`),
//  KEY `ID` (`teamID`)
//) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

}
