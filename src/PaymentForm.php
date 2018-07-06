<?php

/**
 * Form validation manager
 */
class PaymentForm
{
    /**
     * @var string Original HUF amount
    */
    private $amount;

    /**
     * Form data (currently $_POST)
    */
    private $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    /**
     * Check the input we want is in the $this->formData.
     *
     * @param $input string Post value.
     *
     * @return string|null
     */
    private function inputExist($input)
    {
        return isset($this->formData[$input]) ? $this->formData[$input] : null;
    }

    /**
     * Card Number validator manager.
     *
     * @return string|boolean
     */
    public function cardNumberValidation()
    {
        $cardNumber = $this->inputExist('card_number');
        $cardNumberValidator = new CardNumberValidator($cardNumber);

        return $cardNumberErrorMessage = $cardNumberValidator->validate();
    }

    /**
     * Card Expiration Validator manager.
     *
     * @return string|boolean
     */
    public function cardExpirationValidator()
    {
        $expirationYear = $this->inputExist('card_expiration_year');
        $expirationMonth = $this->inputExist('card_expiration_month');
        $cardExpirationValidator = new CardExpirationValidator($expirationYear, $expirationMonth);

        return $cardExpirationErrorMessage = $cardExpirationValidator->validate();
    }

    /**
     * Amount Validator manager.
     *
     * @return string|boolean
     */
    public function amountValidator()
    {
        $amount = $this->inputExist('amount');
        $amountValidator = new AmountValidator($amount);
        $this->amount = $amount;

        return $amountErrorMessage = $amountValidator->validate();
    }

    /**
     * Exchange manager.
     *
     * @return string|boolean
     */
    public function exchangeAmount()
    {
        $amountInEur = null;
        if (!is_null($this->amount)) {
            $MNBCurrencyExchange = new MNBCurrencyExchange($this->amount);

            return $amountInEur = $MNBCurrencyExchange->calculateNewAmount();
        }
    }
}
