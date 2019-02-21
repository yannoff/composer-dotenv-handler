# yannoff/dotenv-handler

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
|:-----------:|:---------------:|:--------------:
|file         | .env            |The name of the auto-generated *dotenv* file
|dist-file    | .env.dist       |The name of the *dist* file
|keep-outdated| true            |Keep values in the *env file* that are not anymore in the *dist file*
