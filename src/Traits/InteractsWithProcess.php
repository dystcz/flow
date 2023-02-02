<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\ProcessHandlerContract;

trait InteractsWithProcess
{
    protected ProcessHandlerContract $handler;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }

    /**
     * Set handler.
     *
     * @param ProcessHandlerContract $handler
     * @return void
     */
    public function setHandler(ProcessHandlerContract $handler): void
    {
        $this->handler = $handler;
    }

    /**
     * Get handler.
     *
     * @param mixed $handler
     * @return ProcessHandlerContract
     */
    public function getHandler(): ProcessHandlerContract
    {
        return $this->handler;
    }
}
