<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supervisor extends Model
{
    use HasFactory;
    use Searchable;
    // use SoftDeletes;

    protected $fillable = [
        'background',
        'availability',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name; 
    }
 
}
