<?php

namespace App\Http\Controllers\API;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $data['post']=post::all();
        return $this->sendResponse($data, 'All posts retrieved successfully');

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->all(), 422);
        }

        $imagePath = $request->file('image')->store('posts', 'public');

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return $this->sendResponse($post, 'Post created successfully!', 201);

    }


    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->sendError('Post not found', [], 404);
        }

        return $this->sendResponse($post, 'Post retrieved successfully');
    }


    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->sendError('Post not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->all(), 422);
        }


        if ($request->hasFile('image')) {

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }


        if ($request->has('title')) {

            $post->title = $request->title;
        }

        if ($request->has('description')) {
            $post->description = $request->description;
        }


        $post->save();

        return $this->sendResponse($post, 'Post updated successfully');
    }


    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->sendError('Post not found', [], 404);
        }

        $post->delete();

        return $this->sendResponse(null, 'Post deleted successfully');
    }
}
