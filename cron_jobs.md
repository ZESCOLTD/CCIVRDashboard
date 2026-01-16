*/10 * * * * cd /var/www/html/CCIVRDashboard && php artisan cdr:process >> /dev/null 2>&1

*/10 * * * * cd /var/www/html/CCIVRDashboard && php artisan cdr:backfill-recordings >> /dev/null 2>&1

0 6 * * * cd /var/www/html/CCIVRDashboard && php artisan chatbot:get-analytics >> /dev/null 2>&1

