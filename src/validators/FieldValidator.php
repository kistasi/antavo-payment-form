<?php

/**
 * Base abstract class for all field validators.
 */
abstract class FieldValidator
{
    /**
     * Check validator given input.
     *
     * @param $input string Input amount
     *
     * @return boolean
     */
    protected function isNotNull($input)
    {
        return !is_null($input);
    }

    /**
     * Check the given input is numeric (string with numbers or integer).
     *
     * @param $input string Input amount
     *
     * @return boolean
     */
    protected function isNumeric($input)
    {
        return is_numeric($input);
    }

    /**
     * Every validator class have validate class method,
     * to call the other methods and handle error messages.
     *
     * @return boolean|string
     */
    abstract public function validate();
}
