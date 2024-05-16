<p align="center"><img src="/docs/open-graphy.png" alt="Logo Laravel Open Graphy"></p>

<p align="center">
<a href="https://packagist.org/packages/saasykit/laravel-open-graphy"><img src="https://img.shields.io/packagist/v/saasykit/laravel-open-graphy.svg?style=flat-square" alt="Build Status"></a>
</p>

Open Graphy is an awesome open graph image (social cards) generator package for Laravel.

With Open Graphy, you can generate social cards for your website dynamically. You can use the default template or create your own template.

**Features:**

- Easily generate open graph images for your website.
- Add title, an image and your logo to the open graph image. 
- Add a screenshot of the page inside the open graph image to show the preview of the page. 
- 5 different templates to choose from.
- Customize the colors and styles of the templates.
- Cache the generated images.
- Create your own template if you want.

**Examples: 👇** 

![open-graphy-examples.png](docs/open-graphy-examples.webp)

## Installation

1. You need to install the `chromium` or `chrome` browser on your server as it's being used by Open Graphy to render images. You can install it using the following command:

**Ubuntu/Debian**:
```bash
sudo apt-get install -y chromium-browser
```

**MacOS**:
```bash
brew install chromium
```

You might also use chrome instead of chromium if you have it installed. In this case you will need to set the `CHROME_BINARY` environment variable to `chrome` in your `.env` file (or set it to null to allow auto discovery of the binary).

**Laravel Sail using MacOS (Apple Silicon)**:
```bash
apt-get install software-properties-common
add-apt-repository ppa:xtradeb/apps -y
apt update
apt install chromium
```

Once done, You can install the package via composer:

```bash
composer require saasykit/laravel-open-graphy
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="open-graphy-config"
```

This is the contents of the published config file:

```php
<?php

// config for SaaSykit/OpenGraphy
return [
    'chrome_binary' => env('CHROME_BINARY', 'chromium'), // leave empty for set to the path of the chrome binary to use, or "chromium" to use the chromium binary
    'open_graph_image' => [  // final generated open graph image settings
        'width' => 1200,
        'height' => 630,
        'type' => 'png',  // png or jpg
    ],

    'image' => null,  // path (relative to public directory) or url to the image to be added to the open graph image

    'logo' => [
        'enabled' => false, // set to false to disable the logo
        'location' => '', // path (relative to public directory) or url to the logo to be added to the open graph image
    ],

    'render_timeout' => 10000, // maximum time to wait for the screenshot to render before failing

    'screenshot' => [
        'enabled' => false,  // set to true to add a screenshot of the page into the open graph image
        'render_width' => 1100,
        'render_height' => 1000,
    ],

    // The cache location to use to store the generated images.
    'storage' => [
        'disk' => 'public',
        'path' => 'open-graphy',
    ],

    'template' => 'verticals',

    'template_settings' => [
        'strings' => [
            'background' => '#5e009e',
            'stroke_color' => '#9f6eee',
            'stroke_width' => '2',
            'text_color' => '#ffffff',
        ],
        'stripes' => [
            'start_color' => '#5e009e',
            'end_color' => '#9f6eee',
            'text_color' => '#ffffff',
        ],
        'sunny' => [
            'start_color' => '#5e009e',
            'end_color' => '#9f6eee',
            'text_color' => '#ffffff',
        ],
        'verticals' => [
            'start_color' => '#FFFFFF',
            'mid_color' => '#F5F5F5',
            'end_color' => '#CCCCCC',
            'text_color' => '#5B4242',
        ],
        'nodes' => [
            'background' => '#330033',
            'node_color' => '#550055',
            'edge_color' => '#440044',
            'text_color' => '#ffffff',
        ],
    ],
];

```

The configs above allow you to edit the colors and styling of the provided templates, but if you prefer to go god mode and edit styles or introduce new templates, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-open-graphy-views"
```

See below for creating a custom template.

## Usage

All what you need to do is to call the following component in your `<head>` tag in your blade file:

```bladehtml
<x-open-graphy::links title="This is an awesome title" image="https://blog.jetbrains.com/wp-content/uploads/2024/04/DSGN-19296_Blog_Post_Image_2.png"/>
```

This will generate the following meta tags in your HTML:

```html


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ahmad Mas](https://github.com/saasykit)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
