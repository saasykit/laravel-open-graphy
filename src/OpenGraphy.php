<?php

namespace SaaSykit\OpenGraphy;

use Illuminate\View\ComponentAttributeBag;

class OpenGraphy
{
    public function __construct(
        private ParameterEncoder $parameterEncoder,
    ) {

    }

    public function generateUrl(array|ComponentAttributeBag $parameters): string
    {
        if ($parameters instanceof ComponentAttributeBag) {
            $parameters = collect($parameters)->all();
        }

        $parameters = collect($parameters)
            ->merge(['.'.config('open-graphy.open_graph_image.type')]) // image extension is needed for twitter compatibility
            ->all();

        if (config('open-graphy.encode_url_base64')) {

            $url = url()->signedRoute('open-graphy.encoded.get', $parameters);

            // get everything after tje ? in the url
            $url = substr($url, strpos($url, '?') + 1);

            // encode the url
            $url = $this->parameterEncoder->base64UrlEncode($url).'.'.config('open-graphy.open_graph_image.type');

            return url()->route('open-graphy.encoded.get', [
                'base64EncodedParameters' => $url,
            ]);
        }

        return url()->signedRoute('open-graphy.get', $parameters);
    }
}
