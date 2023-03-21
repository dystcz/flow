<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Http\Controllers;

use Dystcz\Flow\Domain\Base\Http\Controllers\Controller;
use Dystcz\Flow\Domain\Flows\Http\Resources\TemplateResource;
use Dystcz\Flow\Domain\Flows\Models\Template;
use Illuminate\Http\JsonResponse;

class TemplatesController extends Controller
{
    /**
     * List flow templates.
     */
    public function __invoke(): JsonResponse
    {
        $templates = Template::query()
            ->get();

        return new JsonResponse([
            'templates' => TemplateResource::collection($templates),
        ]);
    }
}
