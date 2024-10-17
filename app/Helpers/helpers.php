<?php


if (! function_exists('format_phone_number')) {
    /**
     * Format a phone number.
     *
     * @param  string  $phone
     * @return string
     */
    function format_phone_number($phone) {
        // Example formatting
        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $phone);
    }
}

if (! function_exists('convert_date')) {
    /**
     * Convert a date to a specific format.
     *
     * @param  string  $date
     * @return string
     */
    function convert_date($date) {
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('throwGeneralException')) {
    /**
     * Throw a GeneralException with a custom message.
     *
     * @param string $message
     * @throws \App\Exceptions\GeneralException
     */
    function throwGeneralException($message)
    {
        throw new \App\Exceptions\GeneralException($message);
    }
}

if (! function_exists('standard_date_format')) {
    function standard_date_format($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-n-j');
    }
}


if (!function_exists('comparable_date_format')) {
    
    function comparable_date_format($date){
        
        $standard_format = standard_date_format($date);

        return strtotime($standard_format);

    }
}

if (!function_exists('number_2_format')) {
    function number_2_format($value)
    {
        $floatValue = floatval($value);
        return number_format($floatValue, 2, '.', ',');
    }
}







?>