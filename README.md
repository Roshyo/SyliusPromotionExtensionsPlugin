# Sylius Promotion Extensions Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Adds common promotion rules and actions for you to use in Sylius.

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require setono/sylius-promotion-extensions-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in the `config/bundles.php` file of your project:

```php
<?php

return [
    // ...
    
    Setono\SyliusPromotionExtensionsPlugin\SetonoSyliusPromotionExtensionsPlugin::class => ['all' => true],
    
    // ...
];
```

It is **IMPORTANT** to add the plugin before the grid bundle else you will get a an exception saying `You have requested a non-existent parameter "setono_sylius_redirect.model.redirect.class".`

[ico-version]: https://img.shields.io/packagist/v/setono/sylius-promotion-extensions-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Setono/SyliusPromotionExtensionsPlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusPromotionExtensionsPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-promotion-extensions-plugin
[link-travis]: https://travis-ci.org/Setono/SyliusPromotionExtensionsPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusPromotionExtensionsPlugin

