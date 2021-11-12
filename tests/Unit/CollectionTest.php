<?php

use MOIREI\Settings\SettingsCollection;

beforeEach(function () {
    $data = ['x' => 4, 'z' => 6];
    $defaults = ['x' => 3, 'y' => 5];

    $this->settings = new SettingsCollection($data, $defaults);
});

it('should merge values', function () {
    expect($this->settings->x)->toEqual(4);
    expect($this->settings->y)->toEqual(5);
    expect($this->settings->z)->toEqual(6);
});

it('should prefer provided default', function () {
    expect($this->settings->get('y'))->toEqual(5);
    expect($this->settings->get('y', 7))->toEqual(7);
    expect($this->settings->get('a'))->toEqual(null);
});

it('should return changes', function () {
    $settings = new SettingsCollection(['x' => 4], ['x' => 3, 'y' => 5]);
    $settings->set('x', 1);
    $settings->set('a', 2);

    expect($settings->x)->toEqual(1);
    expect($settings->original())->toHaveCount(2);
    expect($settings->all())->toHaveCount(3);
});
