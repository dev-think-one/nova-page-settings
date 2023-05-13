# Laravel nova page settings

[![Packagist License](https://img.shields.io/packagist/l/yaroslawww/nova-page-settings?color=%234dc71f)](https://github.com/yaroslawww/nova-page-settings/blob/master/LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/yaroslawww/nova-page-settings)](https://packagist.org/packages/yaroslawww/nova-page-settings)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/nova-page-settings)](https://packagist.org/packages/yaroslawww/nova-page-settings)
[![Build Status](https://scrutinizer-ci.com/g/yaroslawww/nova-page-settings/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/nova-page-settings/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/yaroslawww/nova-page-settings/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/nova-page-settings/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yaroslawww/nova-page-settings/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/nova-page-settings/?branch=master)

Ad hoc solution to add settings configuration to laravel nova.

| Nova | Package |
|------|---------|
| V1   | V1, V2  |
| V4   | V3, V4  |

## Installation

You can install the package via composer:

```bash
composer require yaroslawww/nova-page-settings
```

Optional publish configs

```bash
php artisan vendor:publish --provider="ThinkOne\NovaPageSettings\ServiceProvider" --tag="config"
```

## Usage

### Admin part

1. Create settings table

```injectablephp
public function up() {
    Schema::create( config('nova-page-settings.default.settings_table'), function ( Blueprint $table ) {
        \Thinkone\NovaPageSettings\MigrationHelper::defaultColumns($table);
    } );
}
```

2. Create resource

```injectablephp
namespace App\Nova\Resources;

use Thinkone\NovaPageSettings\AbstractSettingsResource;

class MyPageSetting extends AbstractSettingsResource
{
    
}
```

3. Create templates in folder what you specified in step 3. System will find all templates in folder automatically.

```injectablephp
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

```injectablephp
 /** @var \Illuminate\Support\Collection $pageSettings */
 $pageSettings = \Thinkone\NovaPageSettings\Model\PageSetting;::page(MarketingPageSettings::getSlug())->get();
 // get array of slides using helper
 $slides = $pageSettings->getSettingValue( 'slider', 'array', []);
 // get typed value
 $slides = $pageSettings->arraySettingValue( 'slider', []);
 $slides = $pageSettings->stringSettingValue( 'notification_email');
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/)
