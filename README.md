# Simplified application settings

This package is a simple approach to managing Eloquent model settings.

This package currently does not support managing global app settings.

```php
$notificationsEnabled = $user->settings->get('notifications.enable');
```

## Installation

```bash
composer require moirei/settings
```

Publish the config
```bash
php artisan vendor:publish --tag="model-settings"
```

## Usage

### Cast attributes
The simplest way to use the with a model is casting to the settings collection.

```php
use MOIREI\Settings\AsSettingsCollection;
use MOIREI\Fields\Inputs\Boolean;
...
class User extends Model{
    ...
    protected $casts = [
        'settings' => AsSettingsCollection::class,
    ];

    /**
     * Get settings configuration (optional)
     *
     * @return array
     */
    public function settingsConfig(): array
    {
        return [
            'notifications.enable' => Boolean::make('Enable notification')->default(false),
        ];
    }
}
```

New user models with empty settings should have defauls.
```php
$user = new User();
$notificationsEnabled = $user->settings->get('notifications.enable');

// Or provide a prefered default
$notificationsEnabled = $user->settings->get('notifications.enable', true);
```

Directly access settings values
```php
$notifications = $this->model->settings->notifications;

expect($notifications)->toBeArray();
```

### Has settings trait
For a more function approach to accessing settings, ascribe the `HasSettings` trait to your model.

This trait also provides a default `settingsConfig` method that resolves defaults from `settings.php` config. E.g. the `User` model will expect defaults in `defaults.users` of your config.

```php
use MOIREI\Settings\HasSettings;
...
class User extends Model{
    use HasSettings;
    ...
}
```

```php
$user = new User();
expect($user->settings())->toBeCollection();
expect($user->settings('notifications.enable'))->toBeBool();
```

## Reusable settings

You can reusable settings

```php
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
```

Update in config

```php
// config/settings.php
'groups' => [
   'users' => \App\Settings\UserSettings::class,
],
```

Now your model can be pointed to the config.

```php
class User extends Model{
    use HasSettings;
    
    // optional if lower-cased pluralised form of class name matches name in groups
    protected $settingsConfig = 'users';
}
```



## Tests
```bash
composer test
```