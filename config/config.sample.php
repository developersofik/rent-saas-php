<?php
return [
  'app_name' => 'Rent SaaS',
  'base_url' => getenv('APP_URL') ?: '',
  'db' => [
    'host' => '127.0.0.1',
    'port' => '3306',
    'name' => 'rent_saas',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4'
  ],
  'security' => [
    'session_name' => 'rentsaas_sess',
    'csrf_key' => 'change_this_to_a_random_32_char_string'
  ]
];
