<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(ImageRequest $request): JsonResponse
    {
        $file = $request->file('image');
        $path = $file->store('images', 'public');
        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }
}