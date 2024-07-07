<?php

namespace SaaSykit\OpenGraphy;

class ParameterEncoder
{
    public function base64UrlEncode($input): string
    {
        return strtr(base64_encode($input), '+/=', '-_~');
    }

    public function base64UrlDecode($input): string
    {
        return base64_decode(strtr($input, '-_~', '+/='));
    }
}
