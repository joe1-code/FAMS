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






?>