<?php

/**
 * Exchange Hungarian Forint to Euro.
 */
class MNBCurrencyExchange
{
    /**
     * Originally received amount in HUF.
     *
     * @var string
     */
    private $originalAmount;

    /**
     * @var string The NMB's currency API URL
     */
    const API_URL = 'http://www.mnb.hu/arfolyamok.asmx?wsdl';

    /**
     * @var string The currency we want to change.
     */
    const CURRENCY_NEW = 'EUR';

    /**
     * @var integer
     */
    const RESULT_ROUNDING = 2;

    public function __construct($originalAmount)
    {
        $this->originalAmount = $originalAmount;
    }

    /**
     * Retrieve current EUR currency from MNB.
     *
     * @return string|boolean
     */
    private function getCurrency()
    {
        $client = new SoapClient(self::API_URL);
        $response = $client->__soapCall('GetCurrentExchangeRates', []);

        $doc = new DOMDocument;
        $doc->loadXML($response->GetCurrentExchangeRatesResult);

        $xpath = new DOMXPath($doc);
        $query = "//MNBCurrentExchangeRates/Day/Rate[@curr='" . self::CURRENCY_NEW . "']";
        $entries = $xpath->query($query);

        if ($entries->length) {
            return $entries->item(0)->nodeValue;
        }

        return false;
    }

    /**
     * Changing HUF to EUR.
     *
     * @return float
     */
    public function calculateNewAmount()
    {
        return round($this->originalAmount / $this->getCurrency(), self::RESULT_ROUNDING);
    }
}
