<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Utils\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $postValidation = [
        'content' => 'required|min:10'
    ];

    public function store(Request $req) {
        $data = $req->validate($this->postValidation);

        $user = Auth::user();
        $post = $user->posts()->create($data);

        return response()->json(Api::response($post), 201);
    }

    public function update(Request $req, $id) {
        $data = $req->validate($this->postValidation);
        $user = Auth::user();

        $post = $user->posts()->whereId($id)->first();
        if ($post) {
            $post->update($data);
        }

        return response()->json(Api::response($post));
    }
    
    public function delete(Post $post) {
        $this->authorize('delete', $post);
        
        $post->delete();
        return response()->json([
            'message' => 'Post deleted'
        ]);
    }
}
