<?php

namespace MOIREI\Settings;

abstract class Settings
{
    /**
     * Get settings configuration fields.
     *
     * @return array<string, \MOIREI\Fields\Inputs\Field>
     */
    public abstract function fields(): array;
}
