<?php

namespace SaaSykit\OpenGraphy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SaaSykit\OpenGraphy\OpenGraphImageGenerator;

class OpenGraphyController
{
    public function __construct(
        private OpenGraphImageGenerator $openGraphImageGenerator
    ) {

    }
    public function openGraphImage(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        $title = $request->get('title');
        $url = $request->get('url');

        if (! $title || ! $url) {
            abort(400);
        }

        $logo = $request->boolean('logo', config('open-graphy.logo.enabled'));
        $screenshot = $request->boolean('screenshot', config('open-graphy.screenshot.enabled'));
        $template = $request->get('template', config('open-graphy.template'));

        $fileExtension = config('open-graphy.image.extension');

        // hash all the inputs to create a unique filename
        $filename = md5($title.$logo.$screenshot.$url.$template);

        // storage path
        $disk = config('open-graphy.storage.disk');
        $path = config('open-graphy.storage.path');

        if (! Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->makeDirectory($path);
        }

        $filePath = $path.'/'.$filename.'.'.$fileExtension;

        if (! Storage::disk($disk)->exists($filePath)) {
            $screenshot = $this->openGraphImageGenerator->render($title, $url, $logo, $screenshot, $template);

            Storage::disk($disk)->put($filePath, $screenshot);
        }

        return response(Storage::disk($disk)->get($filePath), 200, [
            'Content-Type' => 'image/'.$fileExtension,
        ]);
    }
}
