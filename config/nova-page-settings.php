<?php

return [
    'db_connection'        => env('NOVA_PAGE_SETTINGS_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),

    'adapter_model_policy' => \Thinkone\NovaPageSettings\QueryAdapter\AdapterModelPolicy::class,
];
