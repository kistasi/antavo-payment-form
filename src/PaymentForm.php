<?php

class PaymentForm
{
    private $amount;
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

    public function cardNumberValidation()
    {
        $cardNumber = $this->inputExist($this->formData['card_number']);
        $cardNumberValidator = new CardNumberValidator($cardNumber);
        return $cardNumberErrorMessage = $cardNumberValidator->validate();
    }

    public function cardExpirationValidator()
    {
        $expirationYear = $this->inputExist($this->formData['card_expiration_year']);
        $expirationMonth = $this->inputExist($this->formData['card_expiration_month']);
        $cardExpirationValidator = new CardExpirationValidator($expirationYear, $expirationMonth);
        return $cardExpirationErrorMessage = $cardExpirationValidator->validate();
    }

    public function amountValidator()
    {
        $amount = $this->inputExist($this->formData['amount']);
        $amountValidator = new AmountValidator($amount);
        $this->amount = $amount;
        return $amountErrorMessage = $amountValidator->validate();
    }

    public function exchangeAmount()
    {
        $amountInEur = null;
        if (!is_null($this->amount)) {
            $MNBCurrencyExchange = new MNBCurrencyExchange($this->amount);
            return $amountInEur = $MNBCurrencyExchange->calculateNewAmount();

        }
    }
}
