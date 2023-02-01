<?php

namespace Dystcz\Process\Http\Controllers;

use Dystcz\Process\Models\ProcessTemplate;

class ProcessTemplatesController extends Controller
{
    public function index()
    {
        $templates = ProcessTemplate::query()
            ->get();
    }
}
