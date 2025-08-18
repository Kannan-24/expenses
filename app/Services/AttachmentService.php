<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    /**
     * Allowed file types for transaction attachments
     */
    private const ALLOWED_TYPES = [
        'image/jpeg',
        'image/jpg', 
        'image/png',
        'image/gif',
        'image/webp',
        'application/pdf',
    ];

    /**
     * Maximum file size in bytes (5MB)
     */
    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    /**
     * Upload transaction attachment
     *
     * @param UploadedFile $file
     * @param int $userId
     * @return array
     * @throws \Exception
     */
    public function uploadAttachment(UploadedFile $file, int $userId): array
    {
        // Validate file type
        if (!in_array($file->getMimeType(), self::ALLOWED_TYPES)) {
            throw new \Exception('File type not allowed. Only images (JPG, PNG, GIF, WebP) and PDF files are supported.');
        }

        // Validate file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \Exception('File size too large. Maximum size is 5MB.');
        }

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'transaction_' . $userId . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        
        // Store file in public disk under attachments folder
        $path = $file->storeAs('attachments', $filename, 'public');

        return [
            'original_name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'url' => 'attachments/' . $filename,
        ];
    }

    /**
     * Delete attachment file
     *
     * @param string $path
     * @return bool
     */
    public function deleteAttachment(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Get attachment URL
     *
     * @param string $path
     * @return string
     */
    public function getAttachmentUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Validate base64 image data
     *
     * @param string $base64Data
     * @return bool
     */
    public function isValidBase64Image(string $base64Data): bool
    {
        // Check if it's a valid base64 image
        if (!preg_match('/^data:image\/(jpeg|jpg|png|gif|webp);base64,/', $base64Data)) {
            return false;
        }

        return true;
    }

    /**
     * Save base64 image as file
     *
     * @param string $base64Data
     * @param int $userId
     * @return array
     * @throws \Exception
     */
    public function saveBase64Image(string $base64Data, int $userId): array
    {
        if (!$this->isValidBase64Image($base64Data)) {
            throw new \Exception('Invalid image data');
        }

        // Extract image data
        preg_match('/^data:image\/(jpeg|jpg|png|gif|webp);base64,/', $base64Data, $matches);
        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        
        // Remove the data URL prefix
        $imageData = preg_replace('/^data:image\/(jpeg|jpg|png|gif|webp);base64,/', '', $base64Data);
        $imageData = base64_decode($imageData);

        if ($imageData === false) {
            throw new \Exception('Failed to decode image data');
        }

        // Check file size
        if (strlen($imageData) > self::MAX_FILE_SIZE) {
            throw new \Exception('Image size too large. Maximum size is 5MB.');
        }

        // Generate unique filename
        $filename = 'camera_' . $userId . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        
        // Store file
        $path = 'attachments/' . $filename;
        Storage::disk('public')->put($path, $imageData);

        return [
            'original_name' => 'Camera Photo.' . $extension,
            'filename' => $filename,
            'path' => $path,
            'size' => strlen($imageData),
            'mime_type' => 'image/' . $extension,
            'url' => 'attachments/' . $filename,
        ];
    }
}
