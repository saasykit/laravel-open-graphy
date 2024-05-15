<?php

if (! function_exists('openGraphy')) {
    function openGraphy(...$args): string
    {
        return \SaaSykit\OpenGraphy\OpenGraphy::generateUrl(...$args);
    }
}
