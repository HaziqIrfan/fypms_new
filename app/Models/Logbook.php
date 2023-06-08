<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logbook extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'datetime',
        'week',
        'approval_date',
        'description',
        'comment',
        'student_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'datetime' => 'datetime',
        'approval_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
