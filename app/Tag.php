<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table='tag';
    protected $primaryKey='id';
    protected $fillable = array('tagName','post_Id','created_at','updated_at');


    public function post()
    {
        return $this->belongsTo(Post::class,'post_Id');
    }

}
