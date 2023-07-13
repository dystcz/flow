# Flow for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dystcz/flow.svg?style=flat-square)](https://packagist.org/packages/dystcz/flow)
[![Total Downloads](https://img.shields.io/packagist/dt/dystcz/flow.svg?style=flat-square)](https://packagist.org/packages/dystcz/flow)
![GitHub Actions](https://github.com/dystcz/flow/actions/workflows/run-tests.yml/badge.svg)

## 🚧 Currently under heavy construction

Undergoing massive [slimming process](https://github.com/dystcz/flow/issues/4) and [quality of life](https://github.com/dystcz/flow/issues/2) improvements. Some may be [overkill](https://github.com/dystcz/flow/issues/5), others sound [reasonable](https://github.com/dystcz/flow/issues/3), but will be [hard](https://github.com/dystcz/flow/issues/6) nonetheless. Any help would be greatly appreciated, so we can get [here](https://github.com/dystcz/flow/milestone/1) at some point. 🥲

## Introduction

Are you sick of inconsistently reimplementing related business processes for your clients?

Do you want to find a common solution which is easy to build and maintain?

Look no more.

This package aims to ease your pain when implementing related business processes / workflows in Laravel.
Right now it uses [DAG](https://en.wikipedia.org/wiki/Directed_acyclic_graph) structure for flow relations.

<!-- - [General idea](#general-idea) -->
<!-- - [Documentation](#documentation) -->
<!--     -   [How to create flow workflow](#flow-workflows) -->
<!--     -   [flow lifecycle events](#flow-lifecycle-events) -->
<!-- - [Installation](#installation) -->

## General idea


### Example flows

- Client project lifecycle (proposal, contract, deposit, development, feedback, ...)
- Multipart forms of any sorts
- Basically any process which can be split into smaller, logical pieces

## Documentation


## Installation

⛔ do not install, without a documentation it's a mess. Wait till v1.

If you still wanna proceeed, you can install the package via composer:

```bash
composer require dystcz/flow
```

The package will automatically register itself (wow).

You can publish the migration with:

```bash
php artisan vendor:publish --provider="Dystcz\Flow\FlowServiceProvider" --tag="migrations"
```

After publishing the migration you can create the tables by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Dystcz\Flow\FlowServiceProvider" --tag="config"
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jakub@dy.st instead of using the issue tracker.

## Credits

-   [Jakub Theimer](https://github.com/theimerj)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


