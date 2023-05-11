<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'due_date', 'start_date'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'due_date' => 'datetime',
        'start_date' => 'datetime',
    ];

    public function studentSubmissions()
    {
        return $this->hasMany(StudentSubmission::class);
    }
}
