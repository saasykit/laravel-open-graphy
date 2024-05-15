<?php

if (! function_exists('openGraphy')) {
    function openGraphy(...$args): string
    {
        return \SaaSykit\OpenGraphy\Facades\OpenGraphy::generateUrl(...$args);
    }
}
