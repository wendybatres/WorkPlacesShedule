@servers(['web' => ['root@24.199.89.105']])

@task('deploy', ['on' => 'web'])
  cd /var/www/cf-laravel-integrador

  git pull origin --rebase main

  composer install --no-interaction --ignore-platform-reqs

  php artisan migrate --force
  php artisan optimize
  php artisan config:cache
@endtask