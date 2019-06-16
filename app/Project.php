<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $guarded = [];
    
    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userProjects() {
        return DB::table('projects')
            ->select(
                'projects.id',
                'projects.created_at', 
                'projects.updated_at', 
                'projects.user_id', 
                'projects.title',
                'projects.description',
                'users.email')
            ->leftJoin('users', 'users.id', '=', 'projects.user_id')->get();
    }
}
