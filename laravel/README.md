# LaraGigs app

Note: This project was taken from https://github.com/bradtraversy/laragigs.

## Usage

### Database Setup

This app uses MySQL. To use something different, open up config/Database.php and change the default driver.

To use MySQL, make sure you install it, setup a database and then add your db credentials(database, username and password) to the .env.example file and rename it to .env

### Migrations

To create all the nessesary tables and columns, run the following

```
php artisan migrate
```

### Seeding The Database

To add the dummy listings with a single user, run the following

```
php artisan db:seed
```

### File Uploading

When uploading listing files, they go to "storage/app/public". Create a symlink with the following command to make them publicly accessible.

```
php artisan storage:link
```

### Running The App

Upload the files to your document root, Valet folder or run

```
php artisan serve
```

### Auto Instrumentation

#### Prerequisites

-   pecl
-   [mw-host-agent](https://docs.middleware.io/agent-installation/overview#installing-the-middleware-agent)

#### Installation

1. Install `gcc`, `make`, `autoconf`
2. Install `opentelemetry` extension

```bash
pecl install opentelemetry
pecl install grpc
```

3. Add the extension to your `php.ini` file:

```ini
[opentelemetry]
extension=opentelemetry.so
[grpc]
extension=grpc.so
```

4. Verify that the extension is installed and enabled:

```bash
php -m | grep opentelemetry
```

5. Install SDK and Instrumentation Libraries in your laravel project

```bash
composer require open-telemetry/sdk open-telemetry/opentelemetry-auto-laravel open-telemetry/transport-grpc
```

### Configuration

#### Environment Configuration

```bash
OTEL_PHP_AUTOLOAD_ENABLED=true \
OTEL_SERVICE_NAME=your-service-name \
OTEL_TRACES_EXPORTER=otlp \
OTEL_EXPORTER_OTLP_PROTOCOL=grpc \
OTEL_EXPORTER_OTLP_ENDPOINT=http://localhost:9319 \
OTEL_PROPAGATORS=baggage,tracecontext \
php artisan serve
```

#### php.ini configuration

```ini
OTEL_PHP_AUTOLOAD_ENABLED=true
OTEL_SERVICE_NAME=your-service-name
OTEL_TRACES_EXPORTER=otlp
OTEL_EXPORTER_OTLP_PROTOCOL=grpc
OTEL_EXPORTER_OTLP_ENDPOINT=http://localhost:9319
OTEL_PROPAGATORS=baggage,tracecontext
```

## License

The LaraGigs app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
