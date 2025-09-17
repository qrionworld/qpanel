<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Http\Resources\ContentResource;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::with('images')->latest()->paginate(10);
        return ContentResource::collection($contents);
    }

    public function show($id)
    {
        $content = Content::with('images')->findOrFail($id);
        return new ContentResource($content);
    }
}
