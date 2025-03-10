<?php

namespace App\Services;

use Illuminate\Support\Str;
use ImageKit\ImageKit;

class ImageKitService
{
    private $imageKit;
    public function __construct()
    {
        $this->imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.url_endpoint')
        );
    }

    public function generateUploadSignature(string $type, string $extension,string $userId): array
    {
        $fileName = "{$userId}-{$type}-" . Str::uuid() . ".{$extension}";

        $sig = $this->imageKit->getAuthenticationParameters();

        return [
            'signature' => $sig->signature,
            'expire' => $sig->expire,
            'token' => $sig->token,
            'filename' => $fileName,
            'tag' => ["{$userId}-user"]
        ];
    }

    public function verifyUpload(string $fileId): bool
    {
        return (bool) $this->imageKit->getFileDetails($fileId);
    }
}
