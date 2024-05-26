<?php

// config for SaaSykit/OpenGraphy
return [
    'chrome_binary' => null, // leave empty for autodiscovery, or set it to 'chrome' or 'chromium' depending on the binary you want to use. You can also provide full path to the binary
    'open_graph_image' => [  // final generated open graph image settings
        'width' => 1200,
        'height' => 630,
        'type' => 'png',  // png or jpg
    ],

    'image' => null,  // path (relative to public directory) or url to the image to be added into the open graph image

    'fallback_open_graph_image' => null,  // path (relative to public directory) or url to the image to be used as a fallback if the open graph image cannot be generated

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

    'template' => 'stripes',

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
