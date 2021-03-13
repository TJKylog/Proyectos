<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class,"user_projects","project_id");
    }

    public function skills()
    {
        return $this->belongsToMany(AcquiredSkill::class,"project_skills","project_id","skill_id");
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,"project_subjects","project_id");
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class,"project_technologies","project_id");
    }
}
