<?php

namespace Suitcore\Currency;

trait ModelCurrencyTrait
{
    public function asCurrency($field)
    {
        $number = $this->{$field};

        if (method_exists($this, 'formatCurrency')) {
            return $this->formatCurrency($number);
        }

        if (function_exists('asCurrency')) {
            return asCurrency($number);
        }
        
        $config = config('livecms.currency');
        $symbol = $config ? $config['symbol'] : '$';
        $decimals = $config ? $config['decimals'] : 2;
        $decimal_separator = $config ? $config['separators.decimal'] : '.';
        $thousand_separator = $config ? $config['separators.decimal'] : ',';

        return $symbol.' '.number_format($number, $decimals, $decimal_separator, $thousand_separator);
    }
}
