<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonalUser
 * @package App\Models\Users
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $city
 */
class PersonalUser extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'signed_up',
        'status'
    ];

    protected $table = 'personal_user';

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
