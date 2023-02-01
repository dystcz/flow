<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Http\Resources\ProcessTemplateResource;
use Dystcz\Process\Models\ProcessTemplate;
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

        return ProcessTemplateResource::collection($templates);
    }
}
