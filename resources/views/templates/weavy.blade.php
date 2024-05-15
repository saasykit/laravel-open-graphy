<html>
<head>
    <title>Open Graph Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">

    @include('open-graphy::partials.font')

{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">--}}

    @include('open-graphy::partials.styles')
    @include('open-graphy::partials.js')

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
