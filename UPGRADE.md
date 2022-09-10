# Upgrade Guide

## General Notes

## Upgrading To 4.0 From 3.x

### Delete `page_setting_value` helper

```php
$slides = page_setting_value( $pageSettings, 'slider', 'array', [] );
// replace to
$slides = $pageSettings->arraySettingValue( 'slider', []);
// or
$slides = $pageSettings->getSettingValue( 'slider', 'array', []);
```

### Other changes

- PageSetting.php model now not abstract and moved to folder /Model
- Now exists default adapter CMSPageSettingModel.php
