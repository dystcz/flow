<?php

namespace Dystcz\Process\Domain\Processes\Http\Controllers;

use Dystcz\Process\Domain\Base\Http\Controllers\Controller;
use Dystcz\Process\Domain\Processes\Http\Resources\ProcessTemplateResource;
use Dystcz\Process\Domain\Processes\Models\ProcessTemplate;
use Illuminate\Http\JsonResponse;

class ProcessTemplatesController extends Controller
{
    /**
     * List process templates.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $templates = ProcessTemplate::query()
            ->get();

        return new JsonResponse([
            'templates' => ProcessTemplateResource::collection($templates),
        ]);
    }
}
