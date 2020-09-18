<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id','description','parent_id','post_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id','id');
    }

    public function replies()
    {
        return $this->children()->with('replies');
    }
}


