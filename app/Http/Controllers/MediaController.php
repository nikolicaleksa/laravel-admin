<?php

namespace App\Http\Controllers;

use App\HasMedia;
use App\Http\Requests\DeleteMediaRequest;
use App\Http\Requests\SaveMediaRequest;
use App\Media;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    private const MEDIA_PER_PAGE = 50;
    private const UPLOADS_DIRECTORY = 'uploads';
    private const ORIGINAL_IMAGE_QUALITY = 100;
    private const IMAGE_QUALITY = 100;
    private const THUMBNAIL_SIZES = [
        'small' => [150, 150],
        'medium' => [300, 300],
        'large' => [1024, 1024],
        'thumbnail' => [128, null],
    ];

    /**
     * MediaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only(['deleteMedia', 'addMedia']);
    }

    /**
     * Display a list of media.
     *
     * @param int $page
     *
     * @return View
     */
    public function showMediaList(int $page = 1): View
    {
        $medias = Media::latest()->paginate(self::MEDIA_PER_PAGE);

        return view('media.media', [
            'medias' => $medias,
        ]);
    }

    /**
     * Display add media form.
     *
     * @return View
     */
    public function showAddMediaForm(): View
    {
        return view('media.add-media');
    }

    /**
     * Delete selected media.
     *
     * @param DeleteMediaRequest $request
     *
     * @return JsonResponse
     */
    public function deleteMedia(DeleteMediaRequest $request): JsonResponse
    {
        $medias = $request->input('medias', []);
        $mediasData =  Media::whereIn('id', $medias)->get();

        foreach ($mediasData as $mediaData) {
             unlink(public_path('uploads/' . $mediaData->file));

            $variants = json_decode($mediaData->variants, true);

            foreach ($variants as $variant) {
                unlink(public_path('uploads/' . $variant));
            }
        }

        HasMedia::whereIn('media_id', $medias)->delete();
        Media::whereIn('id', $medias)->delete();

        return response()->json([
            'code' => JsonResponse::HTTP_OK,
            'response' => trans('messages.media.media-deleted')
        ]);
    }

    /**
     * Add new media.
     *
     * @param SaveMediaRequest $request
     *
     * @return JsonResponse
     */
    public function addMedia(SaveMediaRequest $request): JsonResponse
    {
        $medias = $request->file('medias');

        try {
            foreach ($medias as $media) {
                $originalFileName = $media->getClientOriginalName();
                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $fileName = $this->getUniqueFileName($originalFileName, $extension);
                $name = $this->getMediaNameFromFileName($originalFileName, $extension);
                $mimeType = $media->getClientMimeType();
                $image = Image::make($media);
                $dimensions = $image->width() . 'x' . $image->height();
                $size = $media->getSize();

                $savePath = public_path(self::UPLOADS_DIRECTORY) . '/';
                $uploadDestination = $savePath . $fileName;
                $image->save($uploadDestination, self::ORIGINAL_IMAGE_QUALITY);
                $variants = $this->createMediaThumbnails($uploadDestination, $savePath, $fileName, $extension);

                Media::create([
                    'name' => $name,
                    'file' => $fileName,
                    'mime_type' => $mimeType,
                    'dimensions' => $dimensions,
                    'size' => $size,
                    'variants' => json_encode($variants),
                    'user_id' => $request->user()->id,
                ]);
            }

            return response()->json([
                'code' => JsonResponse::HTTP_OK,
            ], JsonResponse::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex);
            return response()->json([
                'code' => JsonResponse::HTTP_BAD_REQUEST,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get unique file name for the uploaded file.
     *
     * @param string $fileName
     * @param string $extension
     *
     * @return string
     */
    private function getUniqueFileName(string $fileName, string $extension): string
    {
        $fileNameClean = pathinfo($fileName, PATHINFO_FILENAME);
        $fileNameQ = $fileNameClean . '%.' . $extension;
        $media = Media::where('file', 'like', $fileNameQ)->latest()->first();

        if (null !== $media) {
            $regex = sprintf('/%s-(\d+)\.%s/', preg_quote($fileNameClean, '/'), $extension);
            preg_match($regex, $media->file, $iteration);

            if (empty($iteration)) {
                return $fileNameClean . '-1.' . $extension;
            }

            return $fileNameClean . '-' . ($iteration[1] + 1) . '.' . $extension;
        }

        return $fileName;
    }

    /**
     * Get name of the media from file name.
     *
     * @param string $fileName
     * @param string $extension
     *
     * @return string
     */
    private function getMediaNameFromFileName(string $fileName, string $extension): string
    {
        return ucfirst(str_replace(['.' . $extension, '_'], ['', ' '], $fileName));
    }

    /**
     * Create thumbnails for the media.
     *
     * @param string $uploadDestination
     * @param string $savePath
     * @param string $fileName
     * @param string $extension
     *
     * @return array
     */
    private function createMediaThumbnails(string $uploadDestination, string $savePath, string $fileName, string $extension): array
    {
        $variants = [];

        foreach (self::THUMBNAIL_SIZES as $name => $thumbnailSize) {
            $saveName = pathinfo($fileName, PATHINFO_FILENAME) . '-' . $name . '.' . $extension;
            Image::make($uploadDestination)
                ->resize($thumbnailSize[0], $thumbnailSize[1], function ($constraint) use ($thumbnailSize) {
                    if (null === $thumbnailSize[0] || null === $thumbnailSize[1]) {
                        $constraint->aspectRatio();
                    }
                })
                ->save($savePath . $saveName, self::IMAGE_QUALITY);

            $variants[$name] = $saveName;
        }

        return $variants;
    }
}
