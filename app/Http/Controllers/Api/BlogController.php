<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogSingleCollection;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {

        return new BlogCollection(Blog::where('status', 1)->orderBy('featured','desc')->paginate(20));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->get();

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        return new BlogSingleCollection($blog);
    }
}
