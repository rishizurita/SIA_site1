<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Name of table
    protected $table = 'table_user';

    // Columns of table
    protected $fillable = [
        'username',
        'password',
        'gender',
        'jobid'  // Add jobid to the fillable array if it exists in the users table
    ];

    // Disable timestamps in Lumen
    public $timestamps = false;
    const CREATED_AT = null;
    const UPDATED_AT = null;

    // Custom primary key field name
    protected $primaryKey = 'userid';

    // Exclude sensitive fields from JSON responses
    protected $hidden = ['password'];

    // Define relationship with the UserJob model
    public function job()
    {
        return $this->belongsTo(UserJob::class, 'jobid', 'jobid');
    }
}
