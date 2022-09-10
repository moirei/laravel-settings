<?php

use MOIREI\Settings\Tests\User;

beforeEach(function () {
    config([
        'settings.groups.users' => \MOIREI\Settings\UserSettings::class,
        'settings.groups.admins' => \MOIREI\Settings\UserSettings::class,
    ]);
});

it('should get settings config from config using class name', function () {
    $model = new User();

    $config = $model->settingsConfig();
    expect($config)->toBeArray();
    expect($config)->toHaveKey('notifications.enable');
});

it('should get named settings config from config', function () {
    $model = new class extends User
    {
        protected $settingsConfig = 'admins';
    };

    $config = $model->settingsConfig();
    expect($config)->toBeArray();
    expect($config)->toHaveKey('notifications.enable');
});
