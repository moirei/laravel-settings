<?php

namespace MOIREI\Settings;

use MOIREI\Fields\Inputs\Boolean;

/**
 * An example user settings
 */
class UserSettings extends Settings
{
    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'notifications.enable' => Boolean::make('Enable notification')->default(false)
        ];
    }
}
