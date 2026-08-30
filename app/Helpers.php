<?php

if (!function_exists('currency')) {
    function currency($money)
    {
        return '€ ' . number_format($money, 2);
    }
}
