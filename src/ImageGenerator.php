<?php

namespace SaaSykit\OpenGraphy;

use HeadlessChromium\BrowserFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ImageGenerator
{

    public function generate(
        string $title,
        string $url,
        bool $logo,
        bool $screenshot,
        ?string $image,
        ?string $template,
        array $templateSettings = [],
        string $logoUrl = null,
        bool $isTest = false
    )
    {
        $generateWithCommand = config('open-graphy.generate_with_command', false);

        if ($generateWithCommand) {
            Artisan::call('open-graphy:generate', [
                'title' => $title,
                'url' => $url,
                'template' => $template,
                'image' => $image,
                'templateSettings' => json_encode($templateSettings),
                'logoUrl' => $logoUrl,
                '--logo' => $logo,
                '--screenshot' => $screenshot,
                '--test' => $isTest,
            ]);

            $output = Artisan::output();

            return trim($output);
        }

        return $this->processGeneration($title, $url, $logo, $screenshot, $image, $template, $templateSettings, $logoUrl, $isTest);
    }

    public function processGeneration(
        string $title,
        string $url,
        bool $logo,
        bool $screenshot,
        ?string $image,
        ?string $template,
        array $templateSettings = [],
        string $logoUrl = null,
        bool $isTest = false
    )
    {
        $fileExtension = config('open-graphy.open_graph_image.type');

        $template = $template ?? config('open-graphy.template');

        // hash all the inputs to create a unique filename
        $filename = md5($title.$logo.$screenshot.$url.$image.$template.intval($isTest));

        // storage path
        $disk = config('open-graphy.storage.disk');
        $path = config('open-graphy.storage.path');

        if (! Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->makeDirectory($path);
        }

        $filePath = $path.'/'.$filename.'.'.$fileExtension;

        if (! Storage::disk($disk)->exists($filePath) || $isTest) {
            $screenshot = $this->render($title, $url, $logo, $screenshot, $image, $template, $templateSettings, $logoUrl);

            Storage::disk($disk)->put($filePath, $screenshot);
        }

        return $filePath;
    }

    public function streamFromPath(string $path)
    {
//        return response(Storage::disk($disk)->get($filePath), 200, [
//            'Content-Type' => 'image/'.$fileExtension,
//        ]);

        return response()->file($path);
    }

    public function base64FromPath(string $path)
    {
        return base64_encode(Storage::disk(config('open-graphy.storage.disk'))->get($path));
    }

    public function render(
        string $title,
        string $url,
        bool $logoEnabled,
        bool $screenshotEnabled,
        ?string $image,
        string $template,
        array $templateSettings = [],
        string $logoUrl = null
    ) {
        $imageHeight = config('open-graphy.open_graph_image.height');
        $imageWidth = config('open-graphy.open_graph_image.width');
        $browser = (new BrowserFactory(config('open-graphy.chrome_binary')))->createBrowser([
            'windowSize' => [$imageWidth, $imageHeight],
        ]);

        $page = $browser->createPage();

        $logoUrl = $logoUrl ?? config('open-graphy.logo.location');

        $viewName = 'open-graphy::templates.'.$template;
        $templateSettings = empty($templateSettings) ? config('open-graphy.template_settings.'.$template, []) : $templateSettings;

        $data = [
            'title' => $title,
            'templateSettings' => $templateSettings,
        ];

        if ($logoEnabled) {
            $logoImage = $this->getFileLocation($logoUrl);
            $data['logo'] = $this->getImageRepresentation($logoImage);
        }

        if ($screenshotEnabled) {
            $screenshot = $this->renderPage($url);

            if ($screenshot !== null) {
                $data['image'] = $screenshot;
            }
        } elseif ($image) {
            $imagePath = $this->getFileLocation($image);
            $data['image'] = $this->getImageRepresentation($imagePath);
        }

        $page->setHtml(view($viewName, $data)->render(), config('open-graphy.render_timeout'));

        return base64_decode($page->screenshot()->getBase64());
    }

    public function canRender(): bool
    {
        try {
            $browser = (new BrowserFactory(config('open-graphy.chrome_binary')))->createBrowser();
            $page = $browser->createPage();
            $page->setHtml('<html></html>');
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Render a page to an image. The page should be accessible from the internet or from the local network.
     * Will usually NOT work with docker (sail) containers due to container being not aware of its hostname/port
     * For this to work, the full URL of the page (APP_URL . '/path/to/page') should be accessible from this request.
     */
    private function renderPage(string $url): ?string
    {
        $browserHeight = config('open-graphy.screenshot.render_height');
        $browserWidth = config('open-graphy.screenshot.render_width');

        try {
            $browser = (new BrowserFactory(config('open-graphy.chrome_binary')))->createBrowser([
                'windowSize' => [$browserWidth, $browserHeight],
            ]);

            $page = $browser->createPage();

            $page->navigate($url)->waitForNavigation();

            return 'data:image/png;base64, '.$page->screenshot()->getBase64();

        } catch (\Throwable $e) {
            return null;
        }
    }

    private function getFileLocation(string $path)
    {
        // if it starts with domain, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return public_path($path);
    }

    private function getImageRepresentation(string $path): ?string
    {
        try {
            // if $path starts with http or https, return as is
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            $mimeType = mime_content_type($path);

            return 'data:'.$mimeType.';base64, '.base64_encode(file_get_contents($path));
        } catch (\Throwable $e) {
            return null;
        }
    }
}
