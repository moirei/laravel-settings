<?php

namespace MOIREI\Settings;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;

class AsSettingsCollection implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        $defaults = [];
        if (method_exists($model, 'settingsConfig')) {
            foreach ($model->settingsConfig($key) as $k => $config) {
                Arr::set($defaults, $k, $config->getDefault());
            }
        }

        $settings = isset($attributes[$key]) ? json_decode($attributes[$key], true) : [];

        return new SettingsCollection($settings, $defaults);
    }

    public function set($model, $key, $value, $attributes)
    {
        if ($value instanceof SettingsCollection) {
            $value = $value->original();
        }
        return [$key => json_encode($value)];
    }
}
