<?php

/**
 * Base abstract class for all field validators.
 */
abstract class FieldValidator
{
    /**
     * Check validator input set.
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
     * Check the set input is numeric.
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
     * Every validator class have a validate class method,
     * which call the other methods and handle error messages.
     *
     * @return boolean|string
     */
    abstract public function validate();
}
