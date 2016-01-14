# Demander-Container-Plugin

[![Latest Version](https://img.shields.io/github/release/NigelGreenway/Demander-Container-Plugin.svg?style=flat-square)](https://github.com/NigelGreenway/Demander-Container-Plugin/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/NigelGreenway/Demander-Container-Plugin/master.svg?style=flat-square)](https://travis-ci.org/NigelGreenway/Demander-Container-Plugin)

This is a plugin for [NigelGreenway/Demander](https://github.com/NigelGreenway/Demander), a Command/Query mediator.

This implements the Mediator interfaces and allows [League/Container](https://github.com/ThePHPLeague/Container) to load a Query or Command handler.

## Install

Via Composer

``` bash
$ composer require nigelgreenway/demander-container-plugin
```

## Usage

Below is a very basic example on how to use the package. More docs will be released as I get time.

``` php

$container = new Container(null, null, null);

$container->add(
    RegisteredQueryHandler::class,
    RegisteredQueryHandler::class
)->withArgument('query.test');

$container->add(
    RegisteredCommandHandler::class,
    RegisteredCommandHandler::class
)->withArgument('command.test');

$mediator = new ContainerMediator(
    $container,
    [
        RegisteredQuery::class => RegisteredQueryHandler::class,
    ],
    [
        RegisteredCommand::class => RegisteredCommandHandler::class,
    ]
);

$viewModel = $mediator->request(new RegisteredQuery());
echo $viewModel->test; // test.query

$command = $mediator->execute(new RegisteredCommand());
echo $command; // test.command
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email github+demander.security@futurepixels.co.uk instead of using the issue tracker.

## Credits

- [Nigel Greenway](https://github.com/NigelGreenway)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
