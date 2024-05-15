<?php

namespace SaaSykit\OpenGraphy;

use HeadlessChromium\BrowserFactory;

class ImageGenerator
{
    public function render(
        string $title,
        string $url,
        bool $logoEnabled,
        bool $screenshotEnabled,
        ?string $image,
        string $template
    ) {
        $imageHeight = config('open-graphy.open_graph_image.height');
        $imageWidth = config('open-graphy.open_graph_image.width');
        $browser = (new BrowserFactory('chromium'))->createBrowser([
            'windowSize' => [$imageWidth, $imageHeight],
        ]);

        $page = $browser->createPage();

        $logoImage = $this->getFileLocation(config('open-graphy.logo.location'));

        $viewName = 'open-graphy::templates.'.$template;
        $templateSettings = config('open-graphy.template_settings.'.$template, []);

        $data = [
            'title' => $title,
            'templateSettings' => $templateSettings,
        ];

        if ($logoEnabled) {
            $data['logo'] = $this->getInlineBase64Representation($logoImage);
        }

        if ($screenshotEnabled) {
            $screenshot = $this->renderPage($url);

            if ($screenshot !== null) {
                $data['image'] = $screenshot;
            }
        } elseif ($image) {
            $imagePath = $this->getFileLocation($image);
            $data['image'] = $this->getInlineBase64Representation($imagePath);
        }

        $page->setHtml(view($viewName, $data
            //            [
            ////            'image' => $this->renderPage('https://www.smashingmagazine.com/2021/10/object-fit-background-size-css/'),
            ////                        'image' => 'https://unsplash.com/photos/_PaXoN4_2s0/download?ixid=M3wxMjA3fDB8MXxzZWFyY2h8M3x8bGVtb25hZGUlMjBzdGFuZHxlbnwwfHx8fDE3MTU0MzAyOTB8MA&force=true&w=1920',
            //            'logo' => 'data:'.$logoMimeType.';base64,'.base64_encode(file_get_contents($logoImageContent)),
            //        ]
        )->render(), config('open-graphy.render_timeout'));

        return base64_decode($page->screenshot()->getBase64());
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
            $browser = (new BrowserFactory('chromium'))->createBrowser([
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

    private function getInlineBase64Representation(string $path): ?string
    {
        try {
            $mimeType = mime_content_type($path);

            return 'data:'.$mimeType.';base64, '.base64_encode(file_get_contents($path));
        } catch (\Throwable $e) {
            return null;
        }
    }
}
