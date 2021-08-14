rm -rf pub/static/frontend/*
rm -rf var/cache/*
php bin/magento s:s:d -f
php bin/magento indexer:reindex
