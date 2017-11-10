<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Post;
use App\Tag;

use Illuminate\Http\Request;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function insertData(Request $rqs){

       $post = Post::create(['title'=>$rqs->title,'message'=>$rqs->message]);
       $pid = $post['id'];
       $tagsset = array();
        foreach ($rqs->tags as $value) {
           // Tag::create(['tagName' => $value, 'post_Id' => $pid]);

           array_push($tagsset,['tagName' => $value, 'post_Id' => $pid]);

        }

        Tag::insert($tagsset);


        return response()->json($post['id']);
    }

    public function selectData(){
       $data = Post::with('tags')->orderBy('id','DESC')->paginate(2);


       return response()->json($data);
    }



    public function search(Request $rqst){

        $data = Tag::with('post')->orderBy('id','DESC')->paginate(2);


        return response()->json($data);
    }
}
