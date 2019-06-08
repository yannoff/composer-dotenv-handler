# yannoff/composer-dotenv-handler

[![Latest Stable Version](https://poser.pugx.org/yannoff/composer-dotenv-handler/v/stable)](https://packagist.org/packages/yannoff/composer-dotenv-handler)
[![Total Downloads](https://poser.pugx.org/yannoff/composer-dotenv-handler/downloads)](https://packagist.org/packages/yannoff/composer-dotenv-handler)
[![License](https://poser.pugx.org/yannoff/composer-dotenv-handler/license)](https://packagist.org/packages/yannoff/composer-dotenv-handler)

Composer script to handle `.env` file maintenance, based upon the concept of the popular [incenteev/composer-parameter-handler](https://github.com/Incenteev/ParameterHandler) package.

## Usage

First you must require the package:

```bash
$ composer require yannoff/composer-dotenv-handler
```

Then, set up your `composer.json` accordingly, as in the following example:

```json
...
    "scripts": {
        "post-install-cmd": "Yannoff\\DotenvHandler\\ScriptHandler::updateEnvFile"
    }
...

```

## Advanced options

Options may be passed via the `extra` section of the composer.json :

```yaml
    "extra": {
        "yannoff-dotenv-handler": {
            // options here
        }
    }
```

### Available options

|**Name**     |**Default value**|**Description**
|-----------|---------------|--------------
|file         | .env            |The name of the auto-generated *dotenv* file
|dist-file    | .env.dist       |The name of the template file (the *dist* file)
|keep-outdated| true            |Keep values in the *env file* that are not anymore in the *dist file*
|behavior     |normal           |If set to **flex**, enable support for Symfony Flex applications (see [next section](#symfony-flex-behavior) for details)

### Symfony Flex Behavior

As of November 2018, the guys at Symfony decided to [change radically](https://symfony.com/doc/current/configuration/dot-env-changes.html) how `dotenv` files are handled in symfony applications.

A **local** _temporary workaround_ could be to modify the `composer.json` extra section as follow:

```yaml
    "extra": {
        "yannoff-dotenv-handler": {
            "file": ".env.local",
            "dist-file": ".env"
        }
    }
```
Anyway this is not an acceptable solution, indeed the _dotenv file name_ may vary from one deploy environment to another (test, staging, prod...): the `composer.json` can't be committed as is.

_So here comes the behavior option:_

```yaml
    "extra": {
        "yannoff-dotenv-handler": {
            "behavior": "flex"
        }
    }
```

When in **flex behavior mode**, the script will build the **dotenv file name** automatically, based upon either the `APP_ENV` or `ENV` (in this order of preference) environment variable (will use _local_ as default value, if not set) at runtime.

_For example, issuing the following command in a terminal:_

```bash
$ /usr/bin/env ENV=staging composer install
```

_would result in having the following config values:_

- `dist-file` : `.env`
- `file` : `.env.staging`

## Licence

Licensed under the [MIT Licence](LICENSE).
