<?php

/**
 * Bank card expiration validator
 */
class CardExpirationValidator extends FieldValidator
{
    /**
     * @var string Given expiration year.
     */
    protected $expirationYear;

    /**
     * @var string Given expiration month.
     */
    protected $expirationMonth;

    /**
     * @var integer Current year.
     */
    protected $currentYear;

    /**
     * @var integer Current month.
     */
    protected $currentMonth;

    public function __construct($expirationYear, $expirationMonth)
    {
        $this->expirationYear = $expirationYear;
        $this->expirationMonth = $expirationMonth;
    }

    /**
     * Check the given input is only two characters.
     *
     * @param $input string Input amount
     *
     * @return boolean
     */
    private function isOnlyTwoCharacter($input)
    {
        return strlen($input) == 2;
    }

    /**
     * Get the current date in two digit format.
     *
     * @return void
     */
    private function getCurrentDate()
    {
        date_default_timezone_set('Europe/Budapest');
        $this->currentYear = substr(date('Y'), 2);
        $this->currentMonth = date('m');
    }

    /**
     * Check the card is not expired.
     *
     * @return boolean
     */
    private function isNotExpired()
    {
        if ((int) $this->expirationYear > (int) $this->currentYear) {
            return true;
        } else if ((int) $this->expirationYear == (int) $this->currentYear) {
            return (int) $this->expirationMonth >= (int) $this->currentMonth;
        } else {
            return false;
        }
    }

    /**
     * Do validation and handle error messages.
     *
     * @return boolean|string
     */
    public function validate()
    {
        $this->getCurrentDate();

        if (!$this->isNotNull($this->expirationYear)) {
            return 'The expiration year is not given.';
        }

        if (!$this->isNotNull($this->expirationMonth)) {
            return 'The expiration month us is not given.';
        }

        if (!$this->isNumeric($this->expirationYear)) {
            return 'The expiration year is not numeric.';
        }

        if (!$this->isNumeric($this->expirationMonth)) {
            return 'The expiration month is not numeric.';
        }

        if (!$this->isOnlyTwoCharacter($this->expirationYear)) {
            return 'The expiration year date is invalid.';
        }

        if (!$this->isOnlyTwoCharacter($this->expirationMonth)) {
            return 'The expiration year date is invalid.';
        }

        if (!$this->isNotExpired()) {
            return 'The was card expired.';
        }

        return false;
    }
}
