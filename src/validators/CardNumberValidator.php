<?php
/**
 * Validate card number format with the Luhn algorithm
 */
class CardNumberValidator extends FieldValidator
{
    /**
     * @var string Card number.
     */
    private $cardNumber;

    public function __construct($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * Check input with the Luhn algorithm.
     *
     * @return boolean
     */
    private function isValidFormat()
    {
        $sum = 0;
        $numDigits = strlen($this->cardNumber);
        $parity = $numDigits % 2;
        for ($i = 0; $i < $numDigits; $i++) {
            $digit = substr($this->cardNumber, $i, 1);
            if ($parity == ($i % 2)) {
                $digit <<= 1;
                if (9 < $digit) {
                    $digit = $digit - 9;
                }
            }
            $sum += $digit;
        }
        return (0 == ($sum % 10));
    }

    /**
     * Do validation and handle error messages.
     *
     * @return boolean|string
     */
    public function validate()
    {
        if (!$this->isNotNull($this->cardNumber)) {
            return 'The card number is not set.';
        }

        if (!$this->isNumeric($this->cardNumber)) {
            return 'The card number is not numeric.';
        }

        if (!$this->isValidFormat()) {
            return 'The card number format is not valid.';
        }

        return false;
    }
}
