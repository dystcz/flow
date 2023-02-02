<?php

namespace Dystcz\Process\Http\Requests;

use Dystcz\Process\Contracts\ProcessRequestContract;
use Dystcz\Process\Traits\InteractsWithProcess;
use Illuminate\Foundation\Http\FormRequest;

class ProcessRequest extends FormRequest implements ProcessRequestContract
{
    use InteractsWithProcess;
}
