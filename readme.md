# Hesto Generators

- `make:view`
- `make:view:tab`
- `make:view:lang`
- `make:controller:template`
- `make:route:controller`

## Usage

### Step 1: Install Through Composer

```
composer require hesto/generators
```

### Step 2: Add the Service Provider

You'll only want to use these generators for local development, so you don't want to update the production  `providers` array in `config/app.php`. Instead, add the provider in `app/Providers/AppServiceProvider.php`, like so:

```php
public function register()
{
	if ($this->app->environment() == 'local') {
		$this->app->register('Hesto\Generators\GeneratorsServiceProvider');
	}
}
```

### Step 3: Publish config file

Just use

```
php artisan vendor:publish
```

and a hesto/generators.php file will be created in your app/config directory.