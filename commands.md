php artisan cdr:process

sudo journalctl -u ari_proxy.service -r

*/10 * * * * cd /var/www/html/CCIVRDashboard && php artisan cdr:process >> /dev/null 2>&1

*/10 * * * * cd /var/www/html/CCIVRDashboard && php artisan cdr:backfill-recordings >> /dev/null 2>&1



export EDITOR=nano