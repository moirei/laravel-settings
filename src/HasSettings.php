<?php

namespace MOIREI\Settings;

use MOIREI\Fields\Inputs\Field;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasSettings
{
    /**
     * @var string
     */
    protected $settingsColumn = 'settings';

    /**
     * Get settings configuration field
     *
     * @param string $path the settings path
     * @return \MOIREI\Fields\Inputs\Field
     */
    public function settingsField(string $path): Field
    {
        return Arr::get($this->settingsConfig(), $path);
    }

    /**
     * Get settings configuration
     *
     * @return array
     */
    public function settingsConfig(): array
    {
        if (property_exists($this, 'settingsConfig')) {
            if (is_array($this->settingsConfig)) return $this->settingsConfig;
            $settings = (string)$this->settingsConfig;
        } else {
            $name = (new \ReflectionClass(static::class))->getShortName();
            $settings = Str::plural(strtolower($name));
        }

        return Helpers::getSettingsFields(config('settings.groups.' . $settings));
    }

    /**
     * Get settings. Requires settings column to be casted to collection
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function settings(string $key = null, $default = null)
    {
        if (!$key && !$default) {
            return $this->{$this->settingsColumn};
        }

        if ($value = $this->{$this->settingsColumn}->get($key)) {
            return $value;
        }

        /** @var Field $config */
        if (!$default && $config = Arr::get($this->settingsConfig(), $key)) {
            $default = $config->getDefault();
        }

        return $default;
    }
}
