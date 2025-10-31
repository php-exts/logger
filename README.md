## About Logger
- Logger

## Installation
- Install with [Composer](https://getcomposer.org/)
  - `composer require ext/logger`

## Features
- Logger

## Usage
```php
use Zeus\Logger;

$logger = new Logger([
  'name' => 'zeus',
  'max' => 0,
  'permission' => 0644,
  'path' => '',
  'lock' => false,
  'level' => Level::Debug,
  'processors' => [],
  'handlers' => [],
  'timezone' => 'Asia/Shanghai',
  'output_format' => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
  'date_format' => RotatingFileHandler::FILE_PER_DAY,
  'file_format' => "{filename}-{date}"
]);

$logger->info("Hello World", ['foo' => 'bar']);
$logger->debug("Hello World", ['foo' => 'bar']);
$logger->notice("Hello World", ['foo' => 'bar']);
$logger->warning("Hello World", ['foo' => 'bar']);
$logger->error("Hello World", ['foo' => 'bar']);
$logger->critical("Hello World", ['foo' => 'bar']);
$logger->alert("Hello World", ['foo' => 'bar']);
$logger->emergency("Hello World", ['foo' => 'bar']);
```

## Documentation
-

## CHANGELOG
See [CHANGELOG.md]()

## Contributing
-

## Security Vulnerabilities
-

## License

The Project is open-sourced software licensed under the [MIT]() license.

More See https://choosealicense.com/licenses
