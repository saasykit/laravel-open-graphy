@if (isset($attributes['title']) && !empty($attributes['title']))

    @php($attributes['url'] = $attributes['url'] ?? url()->current());

    <meta property="og:image" content="{!! openGraphy($attributes) !!}">
    <meta property="og:image:type" content="image/{{ config('open-graphy.image.type') }}">
    <meta property="og:image:width" content="{{ config('open-graphy.image.width') }}">
    <meta property="og:image:height" content="{{ config('open-graphy.image.height') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{!! openGraphy($attributes) !!}">
@endif
