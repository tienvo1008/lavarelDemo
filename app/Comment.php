<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = "Comment";

    public function tintuc(){
    	return $this->belongsTo('App\TinTuc','idTinTuc','id');
    }
    public function user(){
    	return $this->belongsTo('App\User','idUser','id');	

    	// 1 cmt thuoc 1 user , 1 user nhiue cmt
    }
}
