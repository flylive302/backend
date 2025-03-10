<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ImageKitService;
use Illuminate\Http\Request;
use ImageKit\ImageKit;

class FileUploadController extends Controller
{
    public function getSignedUrl(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'type' => 'required|in:image,video,audio',
            'extension' => 'required|in:webp,jpg,jpeg,png,svg,mp4,mov,avi,mkv,mp3,wav,ogg'
        ]);

        $service = new ImageKitService();
        $data = $service->generateUploadSignature($request->type, $request->extension, $request->user()->id);

        return response()->json($data);
    }
}
