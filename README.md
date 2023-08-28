# Laravel nova page settings

![Packagist License](https://img.shields.io/packagist/l/think.studio/nova-page-settings?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/think.studio/nova-page-settings)](https://packagist.org/packages/think.studio/nova-page-settings)
[![Total Downloads](https://img.shields.io/packagist/dt/think.studio/nova-page-settings)](https://packagist.org/packages/think.studio/nova-page-settings)
[![Build Status](https://scrutinizer-ci.com/g/dev-think-one/nova-page-settings/badges/build.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/nova-page-settings/build-status/main)
[![Code Coverage](https://scrutinizer-ci.com/g/dev-think-one/nova-page-settings/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/nova-page-settings/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dev-think-one/nova-page-settings/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/nova-page-settings/?branch=main)

Ad hoc solution to add settings configuration to laravel nova.

| Nova | Package |
|------|---------|
| V1   | V1, V2  |
| V4   | V3, V4  |

## Installation

You can install the package via composer:

```bash
composer require think.studio/nova-page-settings
```

Optional publish configs

```bash
php artisan vendor:publish --provider="ThinkOne\NovaPageSettings\ServiceProvider" --tag="config"
```

## Usage

### Admin part

1. Create settings table (migration)

```php
public function up() {
    Schema::create( config('nova-page-settings.default.settings_table'), function ( Blueprint $table ) {
        \Thinkone\NovaPageSettings\MigrationHelper::defaultColumns($table);
    } );
}
```

2. Create resource

```php
namespace App\Nova\Resources;

class PageSettingResource extends Resource
{
    use \Thinkone\NovaPageSettings\Nova\Resources\Traits\AsPageSetting;

    public static $model = \Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::class;

    public static $searchable         = false;
    public static $globallySearchable = false;

    public static $title = \Thinkone\NovaPageSettings\QueryAdapter\InternalSettingsModel::ATTR_NAME;

    public static $perPageOptions = [ 1000 ];
    
    public static function label()
    {
        return 'Custom settings';
    }

    public static function uriKey()
    {
        return 'custom-page-settings';
    }
}
```

3. Create templates in folder what you specified in step 3. System will find all templates in folder automatically.

```php
namespace App\Nova\PageSettings\Templates;

use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Thinkone\NovaPageSettings\Templates\BaseTemplate;
use NovaFlexibleContent\Flexible;

class MarketingPageSettings extends BaseTemplate
{
    public function fields(NovaRequest $request)
    {
        return [
            // NOTICE: do not forget use "templateKey" method
            Email::make('Notification email', $this->templateKey('notification_email'));
            Flexible::make('Slider', $this->templateKey('slider'))
                    ->addLayout('Custom Slide', 'custom_slide', [
                        Text::make('Title', 'title'),
                        Textarea::make('Text', 'text'),
                        Text::make('Button Text', 'btn_text'),
                        Text::make('Button Link', 'btn_link'),
                    ])
                    ->limit(4)
                    ->button('Add Slide'),
            // ... other fields
        ];
    }
}
```

4. As a result, you should see something like this:

![](docs/assets/settings-example.gif)

### Frontend part

```php
 /** @var \Illuminate\Support\PageSettingsCollection $pageSettings */
 $pageSettings = MarketingPageSettings::retrieve();
 // get array of slides using helper
 $slides = $pageSettings->getSettingValue( 'slider', 'array', []);
 // get typed value
 $slides = $pageSettings->arraySettingValue( 'slider', []);
 $slides = $pageSettings->stringSettingValue( 'notification_email');

 // or
 /** @var array $viewData */
 $viewData = MarketingPageSettings::viewData();
 echo $viewData['slider'];
```

## Use flexible

If you need to use flexible content package you will need override default model:

```php
namespace App\Models;

class PageSetting extends \Thinkone\NovaPageSettings\Model\PageSetting
{
    use \NovaFlexibleContent\Concerns\HasFlexible;

    public function valueFlexible(array $layoutMapping = []): \NovaFlexibleContent\Layouts\LayoutsCollection
    {
        return $this->flexible('value', $layoutMapping);
    }
}
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/)
