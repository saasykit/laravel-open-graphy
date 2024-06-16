<?php

namespace SaaSykit\OpenGraphy\Http\Controllers;

use Illuminate\Http\Request;
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
            'title' => 'Laravel Open Graphy is Awesome!',
            'url' => url('/'),
            'template' => config('open-graphy.template', 'stripes'),
        ]);

        return $this->processRequest($request, true);
    }

    private function processRequest(Request $request, bool $isTest = false)
    {
        try {
            $title = $request->get('title');
            $url = $request->get('url');

            if (! $title || ! $url) {
                abort(400);
            }

            $logo = $request->boolean('logo', config('open-graphy.logo.enabled'));
            $screenshot = $request->boolean('screenshot', config('open-graphy.screenshot.enabled'));
            $template = $request->get('template', config('open-graphy.template'));
            $image = $request->get('image');

            $filePath = $this->imageGenerator->generate($title, $url, $logo, $screenshot, $image, $template, [], null, $isTest);

            return $this->imageGenerator->streamFromPath($filePath);
        } catch (\Throwable $e) {
            // if fallback_open_graph_image is set, return that image
            $fallbackImage = config('open-graphy.fallback_open_graph_image');

            if ($fallbackImage && file_exists(public_path($fallbackImage))) {
                return response(file_get_contents(public_path($fallbackImage)), 200, [
                    'Content-Type' => 'image/'.pathinfo($fallbackImage, PATHINFO_EXTENSION),
                ]);
            }

            abort(404);
        }
    }
}
