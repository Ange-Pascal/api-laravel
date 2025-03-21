<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query= Post::query(); 
        // nombre d'element par page
        $perPage = 3; 
        // L'utilisateur est par defaut sur la page 1
        $page = $request->input('page', 1); 
        // la barre de recherche 
        $search = $request->input('search'); 
        //L'utilisateur a saisi quelque chose dans la barre de recherche 
        if ($search){
            $query->whereRaw("titre LIKE '%". $search . "%'");
        } 

        $total = $query->count(); 
        $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();
        try { 
            
            return response()->json([
                'status_code' => 200, 
                "status_message" => "Les postes ont été recupérés", 
                'current_page' => $page, 
                'last_page' => ceil($total / $perPage), 
                'items' => $result
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request)
    {

        try {
            $post = new Post();
            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => "le post a été ajouté",
                "data" => $post
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    //fonction update pour editer un post
    public function update(EditPostRequest $request, Post $post)
    {
       try {
         // dd($request);
        // $post = Post::find($id);
        $post->titre = $request->titre;
        $post->description = $request->description;
        $post->save(); 
        
        return response()->json([
            'status_code' => 200,
            'status_message' => "le post a été modifié",
            "data" => $post
        ]);
       } catch (Exception $e) {
        return response()->json($e);
       }
    }

    public function delete(Post $post){
        try {
            if ($post){
                $post->delete(); 
                return response()->json([
                    'status_code' => 200, 
                    'status_message' => "le post e a été supprimé", 
                    'data'=> $post
                ]);
            } else {

                return response()->json([
                    'status_code' => 422, 
                    'status_message' => "Post introuvable", 
               
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}