<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;
    protected $table = 'nflp_teams';
    public $timestamps = false;
    
    protected $fillable = ['teamID','divisionID','city', 'team', 'displayName'];
    protected $primaryKey = 'teamID';
}
