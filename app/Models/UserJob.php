<?php


// change namespace to App\models if you put your model inside models
namespace App\Models;

// library to create Model under lumen
use Illuminate\Database\Eloquent\Model;

class UserJob extends Model{

    // name of table
    protected $table = "tbluserjob";
    //column of table
    protected $fillable = ['jobid','jobname'];

    // The code will not require the field create_at_and update_at in lumen
    public $timestamps = false;

    // The code will customized your own primary key field name, default in lumen is id.
    protected $primaryKey = 'jobid';
}