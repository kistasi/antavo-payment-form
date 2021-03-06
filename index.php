<?php
require 'src/validators/FieldValidator.php';
require 'src/validators/CardNumberValidator.php';
require 'src/validators/CardExpirationValidator.php';
require 'src/validators/AmountValidator.php';
require 'src/MNBCurrencyExchange.php';
require 'src/PaymentForm.php';

$paymentForm = new PaymentForm($_POST);
$cardNumberErrorMessage = $paymentForm->cardNumberValidation();
$cardExpirationErrorMessage = $paymentForm->cardExpirationValidator();
$amountErrorMessage = $paymentForm->amountValidator();
$amountInEur = $paymentForm->exchangeAmount();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payment form</title>

    <style>
        .form-element {
            margin-bottom: 1em;
        }

        .form-element input {
            display: block;
            width: 200px;
        }

        .validation-error {
            color: red;
            display: block;
        }
    </style>
</head>
<body>
<form method="post" novalidate>
    <fieldset>
        <legend>Payment information</legend>
        <div class="form-element">
            <label for="card_number">Credit card number:</label>
            <input type="text" name="card_number" id="card_number" required minlength="19" maxlength="19">
            <?php if ($cardNumberErrorMessage): ?>
                <span class="validation-error">Validation error: <?php echo $cardNumberErrorMessage; ?></span>
            <?php endif; ?>
        </div>

        <fieldset>
            <div class="form-element">
                <label for="card_expiration_year">Credit card expiration year:</label>
                <input type="text" name="card_expiration_year" id="card_expiration_year" required minlength="2"
                       maxlength="2">
            </div>

            <div class="form-element">
                <label for="card_expiration_month">Credit card expiration month:</label>
                <input type="text" name="card_expiration_month" id="card_expiration_month" required minlength="2"
                       maxlength="2">
            </div>

            <?php if ($cardExpirationErrorMessage): ?>
                <span class="validation-error">Validation error: <?php echo $cardExpirationErrorMessage; ?></span>
            <?php endif; ?>
        </fieldset>

        <div class="form-element">
            <label for="amount">Amount of pay (HUF):</label>
            <input type="text" name="amount" id="amount" required minlength="1" maxlength="1000000">
            <?php if ($amountErrorMessage): ?>
                <span class="validation-error">Validation error: <?php echo $amountErrorMessage; ?></span>
            <?php endif; ?>
        </div>

        <?php if (!$cardNumberErrorMessage && !$cardExpirationErrorMessage && !$amountErrorMessage): ?>
            <div style="color: green;">Every given information is valid.</div>
        <?php endif; ?>

        <?php if ($amountInEur): ?>
            <div>Price in Euro: <?php echo $amountInEur ?></div>
        <?php endif; ?>

        <input type="submit" name="submit">
    </fieldset>
</form>
</body>
</html>