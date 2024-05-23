<html>
<head>
    <title>Open Graph Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">

    @include('open-graphy::partials.font')
    @include('open-graphy::partials.styles')
    @include('open-graphy::partials.js')

    @php
        // Usage
        $startColor = $templateSettings['start_color'];
        $midColor = $templateSettings['mid_color'];
        $endColor = $templateSettings['end_color'];

        $textColor = $templateSettings['text_color'];

        $svg = <<<SVG
    <svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'><rect fill='{$startColor}' width='100' height='100'/><g stroke='{$endColor}' stroke-width='0' ><rect fill='{$midColor}' x='-60' y='-60' width='110' height='240'/></g></svg>
SVG;

    @endphp

    <style>
        body {
            background-color: {{ $startColor }};
            background-image: url("data:image/svg+xml,{{ rawurlencode($svg) }}");
        }

        .headline {
            color: {{ $textColor }};
            text-shadow: none;
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
