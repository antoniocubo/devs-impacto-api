<?php

return [
    "api_key" => env("N8N_API_KEY"),
    "auth_header_name" => env("N8N_AUTH_HEADER_NAME", "Authorization"),
    "chat_base_url" => env("N8N_CHAT_BASE_URL", "http://localhost:5678"),
];
