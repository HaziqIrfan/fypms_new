<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentSubmission extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['file_path', 'submission_id', 'student_id'];

    protected $searchableFields = ['*'];

    protected $table = 'student_submissions';

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
