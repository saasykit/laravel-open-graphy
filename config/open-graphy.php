<?php

// config for SaaSykit/OpenGraphy
return [
    'chrome_binary' => env('CHROME_BINARY', 'chromium'), // leave empty for set to the path of the chrome binary to use, or "chromium" to use the chromium binary
    'image' => [  // final generated open graph image settings
        'width' => 1200,
        'height' => 630,
        'type' => 'png',  // png or jpg
    ],

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

    'template' => 'weavy',

    'template_settings' => [
        'weavy' => [

        ],
    ],
];
