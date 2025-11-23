<?php

return [
    "api_key" => env("N8N_API_KEY"),
    "auth_header_name" => env("N8N_AUTH_HEADER_NAME", "Authorization"),
    "chat_base_url" => env("N8N_CHAT_PROD_BASE_URL", "N8N_CHAT_TEST_BASE_URL"),
];
