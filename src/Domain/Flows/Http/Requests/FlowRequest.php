<?php

namespace Dystcz\Flow\Domain\Flows\Http\Requests;

use Dystcz\Flow\Domain\Flows\Contracts\FlowRequestContract;
use Illuminate\Foundation\Http\FormRequest;

class FlowRequest extends FormRequest implements FlowRequestContract
{
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
}
