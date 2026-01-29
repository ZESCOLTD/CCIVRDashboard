php artisan cdr:process

sudo journalctl -u ari_proxy.service -r

*/10 * * * * cd /var/www/html/CCIVRDashboard && php artisan cdr:process >> /dev/null 2>&1

*/10 * * * * cd /var/www/html/CCIVRDashboard && php artisan cdr:backfill-recordings >> /dev/null 2>&1



export EDITOR=nano


php artisan stats:fetch-ussd --start_date=2023-01-01 --end_date=2023-12-31
php artisan stats:fetch-ussd --start_date=2024-01-01 --end_date=2024-12-31
php artisan stats:fetch-ussd --start_date=2025-01-01 --end_date=2025-12-31








php artisan stats:fetch-ussd --start_date=2023-01-01 --end_date=2023-12-31 && \
php artisan stats:fetch-ussd --start_date=2024-01-01 --end_date=2024-12-31 && \
php artisan stats:fetch-ussd --start_date=2025-01-01 --end_date=2025-12-31



php artisan stats:fetch-users --start_date=2023-01-01 --end_date=2023-12-31 --limit=10 && \
php artisan stats:fetch-users --start_date=2024-01-01 --end_date=2024-12-31 --limit=10 && \
php artisan stats:fetch-users --start_date=2025-01-01 --end_date=2025-12-31 --limit=10


php artisan stats:fetch-users --start_date=2023-01-01 --end_date=2023-12-31 && \
php artisan stats:fetch-users --start_date=2024-01-01 --end_date=2024-12-31 && \
php artisan stats:fetch-users --start_date=2025-01-01 --end_date=2025-12-31



Unique Users in 2023:

Bash
php artisan stats:unique --start_date=2023-01-01 --end_date=2023-12-31
Unique Users in 2024:

Bash
php artisan stats:unique --start_date=2024-01-01 --end_date=2024-12-31
Unique Users in 2025:

Bash
php artisan stats:unique --start_date=2025-01-01 --end_date=2025-12-31





php artisan stats:unique --start_date=2023-01-01 --end_date=2023-12-31
php artisan stats:unique --start_date=2024-01-01 --end_date=2024-12-31
php artisan stats:unique --start_date=2025-01-01 --end_date=2025-12-31


