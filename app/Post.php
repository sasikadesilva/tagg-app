<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model


{
    protected $table='post';
    protected $primaryKey='id';
    protected $fillable = array('title','message','created_at','updated_at');


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class, 'post_Id');


    }


}
