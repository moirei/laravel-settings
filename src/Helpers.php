<?php

namespace MOIREI\Settings;


class Helpers
{
    /**
     * Recursively merge array
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    static function arrayMergeRecursiveDistinct(array &$array1, array &$array2): array
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = static::arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    /**
     * Get the settings fields from a settings class.
     *
     * @param string $settings
     * @return array<string, \MOIREI\Fields\Inputs\Field>
     */
    static function getSettingsFields($settings): array
    {
        if (class_exists($settings)) {
            /** @var Settings $instance */
            $instance = app($settings);
            return $instance->fields();
        }

        return [];
    }
}
