<?php

namespace SaaSykit\OpenGraphy;

use Illuminate\View\ComponentAttributeBag;

class OpenGraphy
{
    public function generateUrl(array|ComponentAttributeBag $parameters): string
    {
        if ($parameters instanceof ComponentAttributeBag) {
            $parameters = collect($parameters)->all();
        }

        $parameters = collect($parameters)
            ->merge(['.'.config('open-graphy.open_graph_image.type')]) // image extension is needed for twitter compatibility
            ->all();

        return url()->signedRoute('open-graphy.get', $parameters);
    }
}
