<?php
/**
 * Amount validator
 */
class AmountValidator extends FieldValidator
{
    /**
     * @var string Input amount.
     */
    private $amount;

    /**
     * @var integer Minimum amount.
     */
    const MINIMUM_AMOUNT = 1;

    /**
     * @var integer Maximum amount.
     */
    const MAXIMUM_AMOUNT = 1000000;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Check the amount is in the range.
     *
     * @return boolean
     */
    public function isInRange()
    {
        return $this->amount <= self::MAXIMUM_AMOUNT && $this->amount > self::MINIMUM_AMOUNT;
    }

    /**
     * Do validation and handle error messages.
     *
     * @return boolean|string
     */
    public function validate()
    {
        if (!$this->isNotNull($this->amount)) {
            return 'The amount is not set.';
        }

        if (!$this->isNumeric($this->amount)) {
            return 'The amount is not numeric.';
        }

        if (!$this->isInRange()) {
            return 'The amount is not between ' . self::MINIMUM_AMOUNT . ' and ' . self::MAXIMUM_AMOUNT . '.';
        }

        return false;
    }
}
