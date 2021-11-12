<?php

use MOIREI\Fields\Inputs\Field;
use Illuminate\Database\Eloquent\Model;
use MOIREI\Fields\Inputs\Boolean;
use MOIREI\Settings\AsSettingsCollection;
use MOIREI\Settings\HasSettings;
use MOIREI\Settings\SettingsCollection;

beforeEach(fn () => $this->model = new class extends Model
{
    use HasSettings;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'settings' => AsSettingsCollection::class,
    ];

    /**
     * Get settings configuration
     *
     * @return array
     */
    public function settingsConfig(): array
    {
        return [
            'notifications.enable' => Boolean::make('Enable notification')->default(false),
        ];
    }
});

it('expects settings to be collection', function () {
    expect($this->model->settings)->toBeCollection();
    expect($this->model->settings())->toBeCollection();
});

it('should set & get settings', function () {
    $settings = $this->model->settings;
    $settings->set('notifications.channel', 'email');
    expect($this->model->settings->notifications)->toBeArray();
    expect($settings->get('notifications')['channel'])->toEqual('email');
    expect($settings->get('notifications.channel'))->toEqual('email');
    expect($this->model->settings('notifications.channel'))->toEqual('email');
});

it('should have settings field', function () {
    $field = $this->model->settingsField('notifications.enable');
    expect($field)->toBeInstanceOf(Field::class);
    expect($this->model->settings('notifications.enable'))->toBeFalse();
});

it('should have filled settings field', function () {
    $attributes = [
        'settings' => [
            'notifications' => [
                'enable' => true,
                'channel' => 'email',
            ]
        ]
    ];
    $model = new class($attributes) extends Model
    {
        protected $fillable = ['settings'];
        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'settings' => AsSettingsCollection::class,
        ];
    };

    expect($model->settings->get('notifications.enable'))->toBeTrue();
    expect($model->settings->get('notifications.channel'))->toEqual('email');
    expect($model->settings)->toBeInstanceOf(SettingsCollection::class);
});
