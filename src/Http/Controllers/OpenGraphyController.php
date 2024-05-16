<?php

namespace SaaSykit\OpenGraphy\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SaaSykit\OpenGraphy\ImageGenerator;

class OpenGraphyController
{
    public function __construct(
        private ImageGenerator $imageGenerator
    ) {

    }

    public function openGraphImage(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        return $this->processRequest($request);
    }

    public function test(Request $request)
    {
        if (! app()->environment('local')) {
            abort(404);
        }

        $request->mergeIfMissing([
            'title' => 'SaaSykit Open Graphy is Awesome!',
            'url' => 'https://saasykit.com',
            'logo' => false,
            'screenshot' => false,
            'template' => 'stripes',
        ]);

        return $this->processRequest($request, true);
    }

    private function processRequest(Request $request, bool $isTest = false)
    {
        $title = $request->get('title');
        $url = $request->get('url');

        if (! $title || ! $url) {
            abort(400);
        }

        $logo = $request->boolean('logo', config('open-graphy.logo.enabled'));
        $screenshot = $request->boolean('screenshot', config('open-graphy.screenshot.enabled'));
        $template = $request->get('template', config('open-graphy.template'));
        $image = $request->get('image');

        $fileExtension = config('open-graphy.open_graph_image.type');

        // hash all the inputs to create a unique filename
        $filename = md5($title.$logo.$screenshot.$url.$image.$template);

        // storage path
        $disk = config('open-graphy.storage.disk');
        $path = config('open-graphy.storage.path');

        if (! Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->makeDirectory($path);
        }

        $filePath = $path.'/'.$filename.'.'.$fileExtension;

        if (! Storage::disk($disk)->exists($filePath) || $isTest) {
            $screenshot = $this->imageGenerator->render($title, $url, $logo, $screenshot, $image, $template);

            Storage::disk($disk)->put($filePath, $screenshot);
        }

        return response(Storage::disk($disk)->get($filePath), 200, [
            'Content-Type' => 'image/'.$fileExtension,
        ]);
    }
}
