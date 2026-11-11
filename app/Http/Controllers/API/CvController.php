<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * The app's CV tab: each admin keeps one PDF and one Word CV. Uploading a new file replaces the old
 * one, and the public link of each type never changes, so a shared link always serves the latest CV.
 * Files live on the private "local" disk (storage/app/cvs/{admin_id}/{type}/) and are only served
 * through download(), which checks the link's signature.
 */
class CvController extends Controller
{
    private const TYPES = ['pdf', 'docx'];
    private const MAX_KB = 10240;

    /**
     * GET /cv
     * The signed-in admin's PDF and Word CV (null when not uploaded yet).
     */
    public function index()
    {
        try {
            $adminId = auth('admin-api')->id();

            $files = [];
            foreach (self::TYPES as $type) {
                $files[$type] = $this->describe($adminId, $type);
            }

            return successResponse($files);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /cv/{type}  (multipart, field "file")
     * Replaces the signed-in admin's CV of that type.
     */
    public function upload(Request $request, string $type)
    {
        try {
            if (!in_array($type, self::TYPES, true)) {
                return failedResponse('Unknown CV type.');
            }
            $request->validate([
                'file' => 'required|file|mimes:' . $type . '|max:' . self::MAX_KB,
            ], [
                'file.mimes' => $type === 'pdf' ? 'Choose a PDF file.' : 'Choose a Word (.docx) file.',
                'file.max'   => 'The CV must be 10 MB or smaller.',
            ]);
            $adminId = auth('admin-api')->id();
            $dir = $this->dir($adminId, $type);
            $disk = Storage::disk('local');

            $name = $this->cleanName($request->file('file')->getClientOriginalName(), $type);
            $old = $disk->files($dir);

            $disk->putFileAs($dir, $request->file('file'), $name);

            // Remove the previous CV only after the new one is safely stored
            $disk->delete(array_values(array_filter($old, fn ($path) => basename($path) !== $name)));

            return successResponse($this->describe($adminId, $type));
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /cv/{admin}/{type}/{signature}  (public, no login)
     * Downloads the latest CV of that type. The signature makes the link unguessable.
     */
    public function download(Request $request, int $admin, string $type, string $signature)
    {
        if (!in_array($type, self::TYPES, true) || !hash_equals($this->signature($admin, $type), $signature)) {
            abort(404);
        }

        $path = $this->currentPath($admin, $type);
        if (!$path) {
            abort(404);
        }

        // Never cached, so the link always returns the file uploaded last
        return Storage::disk('local')->download($path, basename($path), [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
        ]);
    }

    private function dir(int $adminId, string $type): string
    {
        return "cvs/{$adminId}/{$type}";
    }

    private function currentPath(int $adminId, string $type): ?string
    {
        return Storage::disk('local')->files($this->dir($adminId, $type))[0] ?? null;
    }

    private function signature(int $adminId, string $type): string
    {
        return substr(hash_hmac('sha256', "cv|{$adminId}|{$type}", config('app.key')), 0, 32);
    }

    private function describe(int $adminId, string $type): ?array
    {
        $path = $this->currentPath($adminId, $type);
        if (!$path) {
            return null;
        }
        $disk = Storage::disk('local');

        return [
            'type'        => $type,
            'name'        => basename($path),
            'size'        => $disk->size($path),
            'uploaded_at' => date(DATE_ATOM, $disk->lastModified($path)),
            'url'         => url("/api/cv/{$adminId}/{$type}/" . $this->signature($adminId, $type)),
        ];
    }

    // Keeps the uploaded file's name (it becomes the downloaded file's name) without path or odd characters
    private function cleanName(string $original, string $type): string
    {
        $base = pathinfo($original, PATHINFO_FILENAME);
        $base = trim(preg_replace('/[^\pL\pN _().-]+/u', '', $base), " .-");

        return ($base !== '' ? mb_substr($base, 0, 120) : 'CV') . '.' . $type;
    }
}
