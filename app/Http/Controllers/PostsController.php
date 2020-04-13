<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index(){
        $Posts = Post::latest()->get();
        return response()->json([
            'success'=>true,
            'message'=>'List Semua Post',
            'data'=>$Posts
        ],200);
    }

    public function store(Request $request){
        //validate data
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required'
        ],[
            'title.required'=>'Masukan Title Post !',
            'content.required'=>'Masukan Content Post !'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>true,
                'message'=>'Silahkan Isi Bidang Yang Kosong !',
                'data'=>$validator->errors()
            ],400);
        }else{

            $post = Post::create([
                'title'=>$request->input('title'),
                'content'=>$request->input('content')
            ]);

            if($post){
                return response()->json([
                    'success'=>true,
                    'message'=>'Post Berhasil Di Tambahkan'
                ],200);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Post Gagal Di Simpan'
                ],400);
            }
        }
    }

    public function show($id){
        $post = Post::whereId($id)->first();

        if($post){
            return response()->json([
                'success'=>true,
                'message'=>'Detail Post!',
                'data'=>$post
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Post Tidak Di Temukan',
                'data'=>''
            ],404);
        }
    }

    public function update(Request $request){
        //validate data
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required'
        ],[
            'title.required'=>'Masukan Title Post Yang Akan Di Update !',
            'content.required'=>'Masukan Content Post Yang Akan Di Update !!'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>true,
                'message'=>'Silahkan Isi Bidang Yang Kosong !',
                'data'=>$validator->errors()
            ],400);
        }else{
            $post = Post::whereId($request->input('id'))->update([
                'title'=>$request->input('title'),
                'content'=>$request->input('content')
            ]);

            if($post){
                return response()->json([
                    'success'=>true,
                    'message'=>'Post Berhasil Di Update'
                ],200);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Post Gagal Di Update'
                ],500);
            }
        }
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();

        if($post){
            return response()->json([
                'secces'=>true,
                'message'=>'Post Berhasil Di Hapus !'
            ],200);
        }else{
            return response()->json([
                'secces'=>false,
                'message'=>'Post Gagal Di Hapus !'
            ],500);
        }
    }

}
