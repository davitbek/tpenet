<?php

namespace LaraAreaValidator\Rules;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class CustomRule
{
    protected $rule;

    /**
     * Return rule name
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Get Request
     *
     * @return Request
     */
    protected function getRequest()
    {
        return app('request');
    }

    /**
     * Add data in request
     *
     * @param $data
     */
    protected function mergeInRequestData($data)
    {
        $this->getRequest()->merge($data);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Validation Error';
    }

    /**
     * Set new validation message
     *
     * @param $message
     * @param Validator|null $validator
     */
    public function setMessage($message, ? Validator $validator = null)
    {
        $validator = $validator ?? debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['args'][3];
        $validator->setCustomMessages([$this->rule => $message]);
    }

    /**
     * For array nested attribute name
     *
     * @param $attribute
     * @param $value
     * @return string
     */
    public function getNestedAttributeName($attribute, $value)
    {
        return $attribute . '.' . $value;
    }
}
