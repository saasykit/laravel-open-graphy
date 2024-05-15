<html>
<head>
    <title>Open Graph Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">

    @include('open-graphy::partials.font')
    @include('open-graphy::partials.styles')
    @include('open-graphy::partials.js')

    <style>
        body {
            background-color: {{ config('open-graphy.template_settings.strings.background') }};

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='250' height='30' viewBox='0 0 1000 120'%3E%3Cg fill='none' stroke='%23{{str_replace('#', '', config('open-graphy.template_settings.strings.stroke_color))}}' stroke-width='{{str_replace("#", "", config("open-graphy.template_settings.strings.stroke_width"))}}' %3E%3Cpath d='M-500 75c0 0 125-30 250-30S0 75 0 75s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 45c0 0 125-30 250-30S0 45 0 45s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 105c0 0 125-30 250-30S0 105 0 105s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 15c0 0 125-30 250-30S0 15 0 15s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500-15c0 0 125-30 250-30S0-15 0-15s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 135c0 0 125-30 250-30S0 135 0 135s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3C/g%3E%3C/svg%3E");
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
        <div class="headline-container {{!$imageIsSet? 'full-width' : ''}}">
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
