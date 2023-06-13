<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use App\Models\Traits\FilamentTrait;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles;
    use Notifiable;
    use HasFactory;
    use Searchable;
    // use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'matric_id', 'password', 'phonenum'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token'];

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function supervisors()
    {
        return $this->hasOne(Supervisor::class);
    }

    public function evaluator()
    {
        return $this->hasOne(Evaluator::class);
    }

    public function canAccessFilament(): bool
    {
        return true;
    }
    public function getRolesNameAttribute()
    {
        $roles = "";
        foreach (auth()->user()->roles as $index => $role) {
            if ($index != 0) {
                $roles .= "/";
            }
            $roles .= $role->name;
        }
        return $roles;
    }
}
