<?php

/**
 * custom message error for response
 */
if (! function_exists('parseErrToJson')) {
    /**
     * @param $validator
     * @return array
     */
    function parseErrToJson($validator) {
        $messages = $validator->errors()->messages();
        $result = [];
        foreach ($messages as $key => $value) {
            $result[$key] = $value[0];
        }
        return $result;
    }
}