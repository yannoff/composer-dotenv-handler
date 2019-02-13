# yannoff/dotenv-handler

Composer script to handle `.env` file maintenance, based upon the concept of the popular [incenteev/composer-parameter-handler](https://github.com/Incenteev/ParameterHandler) package.

## Usage

First you must require the package:

```bash
$ composer require yannoff/dotenv-handler
```

Then, set up your `composer.json` accordingly, as in the following example:

```json
...
"scripts": {
    "post-install-cmd": "Yannoff\\DotenvHandler\\ScriptHandler::updateEnvFile"
}
...

```
