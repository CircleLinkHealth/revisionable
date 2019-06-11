<?php

/*
 * This file is part of CarePlan Manager by CircleLink Health.
 */

namespace Venturecraft\Revisionable;

/**
 * FieldFormatter.
 *
 * Allows formatting of fields
 *
 * (c) Venture Craft <http://www.venturecraft.com.au>
 */

/**
 * Class FieldFormatter.
 */
class FieldFormatter
{
    /**
     * Boolean.
     *
     * @param       $value
     * @param array $options The false / true values to return
     *
     * @return string Formatted version of the boolean field
     */
    public static function boolean($value, $options = null)
    {
        if ( ! is_null($options)) {
            $options = explode('|', $options);
        }

        if (2 != sizeof($options)) {
            $options = ['No', 'Yes'];
        }

        return $options[(bool) $value];
    }

    /**
     * Format the datetime.
     *
     * @param string $value
     * @param string $format
     *
     * @return formatted datetime
     */
    public static function datetime($value, $format = 'Y-m-d H:i:s')
    {
        if (empty($value)) {
            return null;
        }

        $datetime = new \DateTime($value);

        return $datetime->format($format);
    }

    /**
     * Format the value according to the provided formats.
     *
     * @param  $key
     * @param  $value
     * @param  $formats
     *
     * @return string formatted value
     */
    public static function format($key, $value, $formats)
    {
        foreach ($formats as $pkey => $format) {
            $parts = explode(':', $format);
            if (1 === sizeof($parts)) {
                continue;
            }

            if ($pkey == $key) {
                $method = array_shift($parts);

                if (method_exists(get_class(), $method)) {
                    return self::$method($value, implode(':', $parts));
                }
                break;
            }
        }

        return $value;
    }

    /**
     * Check if a field is empty.
     *
     * @param $value
     * @param array $options
     *
     * @return string
     */
    public static function isEmpty($value, $options = [])
    {
        $value_set = isset($value) && '' != $value;

        return sprintf(self::boolean($value_set, $options), $value);
    }

    /**
     * Format the string response, default is to just return the string.
     *
     * @param  $value
     * @param  $format
     *
     * @return formatted string
     */
    public static function string($value, $format = null)
    {
        if (is_null($format)) {
            $format = '%s';
        }

        return sprintf($format, $value);
    }
}
