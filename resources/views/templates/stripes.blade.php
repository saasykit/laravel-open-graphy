<html>
<head>
    <title>Open Graph Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">

    @include('open-graphy::partials.font')
    @include('open-graphy::partials.styles')
    @include('open-graphy::partials.js')

    @php
        function generateIntermediateColors($startColor, $endColor, $steps) {
            // Remove the '#' from the color codes
            $startColor = str_replace('#', '', $startColor);
            $endColor = str_replace('#', '', $endColor);

            $startRGB = [
                hexdec(substr($startColor, 0, 2)),
                hexdec(substr($startColor, 2, 2)),
                hexdec(substr($startColor, 4, 2))
            ];

            $endRGB = [
                hexdec(substr($endColor, 0, 2)),
                hexdec(substr($endColor, 2, 2)),
                hexdec(substr($endColor, 4, 2))
            ];

            $stepRGB = [
                ($endRGB[0] - $startRGB[0]) / $steps,
                ($endRGB[1] - $startRGB[1]) / $steps,
                ($endRGB[2] - $startRGB[2]) / $steps,
            ];

            $intermediateColors = [];

            for ($i = 0; $i <= $steps; $i++) {
                $intermediateRGB = [
                    round($startRGB[0] + $i * $stepRGB[0]),
                    round($startRGB[1] + $i * $stepRGB[1]),
                    round($startRGB[2] + $i * $stepRGB[2]),
                ];

                $intermediateColors[] = sprintf("#%02x%02x%02x", $intermediateRGB[0], $intermediateRGB[1], $intermediateRGB[2]);
            }

            return $intermediateColors;
        }

        // Usage
        $startColor = $templateSettings['start_color'];
        $endColor = $templateSettings['end_color'];
        $steps = 5;

        $colors = generateIntermediateColors($startColor, $endColor, $steps);

        $textColor = $templateSettings['text_color'];

        $svg = <<<SVG
    <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 1600 800'><rect fill='{$colors[0]}' width='1600' height='800'/><g ><polygon fill='{$colors[1]}' points='1600 160 0 460 0 350 1600 50'/><polygon fill='{$colors[2]}' points='1600 260 0 560 0 450 1600 150'/><polygon fill='{$colors[3]}' points='1600 360 0 660 0 550 1600 250'/><polygon fill='{$colors[4]}' points='1600 460 0 760 0 650 1600 350'/><polygon fill='{$colors[5]}' points='1600 800 0 800 0 750 1600 450'/></g></svg>
SVG;


    @endphp

    <style>
        body {
            background-color: {{ $startColor }};
            background-image: url("data:image/svg+xml,{{ rawurlencode($svg) }}");
            background-attachment: fixed;
            background-size: cover;
        }

        .headline {
            color: {{ $textColor }};
        }
    </style>

    <script>
        // on DOM load
        document.addEventListener("DOMContentLoaded", function() {
            resizeText({
                elements: document.querySelectorAll('.headline'),
                step: 1
            })
        });
    </script>

</head>
<body>
    <div class="top-container">
        @php($imageIsSet = isset($image) && !empty($image))
        <div class="headline-container {{isset($logo) ? 'flex-column' : 'flex-row'}} {{!$imageIsSet? 'full-width' : ''}}">
            @if (isset($logo))
                <img class="logo" src="{{ $logo }}" alt="Logo">
            @endif
            <h1 class="headline">{!! $title !!}</h1>

        </div>

        @if ($imageIsSet)
            <div class="image-container">
                <img class="image" src="{{ $image }}" alt="Social Graph Image">
            </div>
        @endif
    </div>
</body>

</html>
