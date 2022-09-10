<?php

return [
    'default' => [
        'settings_table' => 'cms_page_settings',
        'settings_model' => \Thinkone\NovaPageSettings\Model\PageSetting::class,
        'templates_path' => 'app/Nova/PageSettings/Templates',
    ],
    'db_connection'        => env('NOVA_PAGE_SETTINGS_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
    'adapter_model_policy' => \Thinkone\NovaPageSettings\QueryAdapter\AdapterModelPolicy::class,
];
