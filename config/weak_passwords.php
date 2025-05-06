<?php
// config/weak_passwords.php
return [
'password',
'123456',
'12345678',
'qwerty',
'letmein',
'admin123',
'abc123',
'welcome',
];

$weakPasswords = Config::get('weak_passwords', [
    'password', '123456', '12345678', 'qwerty', 'letmein', 'admin123', 'abc123', 'welcome'
]);
