<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'project_title',
        'psm_status',
        'year',
        'program',
        'pa_name',
        'user_id',
        'supervisor_id',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function studentSubmissions()
    {
        return $this->hasMany(StudentSubmission::class);
    }

    public function evaluationResults()
    {
        return $this->hasMany(EvaluationResult::class);
    }

    public function evaluators()
    {
        return $this->belongsToMany(Evaluator::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name; 
    }
}
