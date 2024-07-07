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
            return url()->signedRoute('open-graphy.encoded.get', [
                'base64EncodedParameters' => $this->parameterEncoder->base64UrlEncode(http_build_query($parameters)).'.'.config('open-graphy.open_graph_image.type'),
            ]);
        }

        return url()->signedRoute('open-graphy.get', $parameters);
    }
}
