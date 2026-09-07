# Laravel E-commerce

An e-commerce application built with Laravel. Supports headless storefronts via API.

## Overview

The application supports the core online-shopping flow: browsing products, managing a cart, placing orders, and tracking order information. Business rules are enforced server-side through Laravel's application and validation layers.

## Getting started

1. Install dependencies:

	```bash
	composer install
	```

2. Create the environment file and configure the application and database:

	```bash
	cp .env.example .env
	php artisan key:generate
	```

3. Run migrations:

	```bash
	php artisan migrate
	```

4. Start the development server:

	```bash
	php artisan serve
	```

Open the URL shown by Artisan in a browser.

## Common commands

```bash
php artisan migrate
php artisan test
php artisan route:list
```

## Configuration

Set the database, application URL, mail, and payment-related values in `.env` as required by the deployment environment. Never commit credentials or other secrets.
