<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CollectionModel extends Model
{
    //
    protected $table = 'think_collection';


    protected $fillable = [
        'factory_id',
        'openid'
    ];
}
