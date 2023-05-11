<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationResult extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'mark',
        'evaluation_id',
        'student_id',
        'evaluator_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'evaluation_results';

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Evaluator::class);
    }
}
