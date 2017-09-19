# Magento To Sentry Logger

The purpose of this project is to log the magento error and exception messages to sentry, too. This extension is an extension of the [Firegento Logger module](https://github.com/firegento/firegento-logger), so you need the Logger module to use the Sentry logger.

# Installation
## Installing Without Composer
If you're not using composer to manage non-magento 3rd party packages, then you can install simply by:
1. Pull down the code somewhere (`git clone git@github.com:magento-hackathon/LoggerSentry.git`)
2. Copy over all files associatively.
3. Configure the module (see below).

## Installtion With Composer
Add to your repositories:

```
"repositories": [
	    {
            "type": "composer",
            "url": "http://packages.firegento.com"
        }
    ],
```

Install with composer:

`composer require magento-hackathon/loggersentry`

Additional requirements:

[firegento/logger](https://github.com/firegento/firegento-logger)

## Configuration

After you install the module you can configure it in the backend at: `System > Configuration > Advanced > FireGento Logger > Sentry Logger`

## Further Information

### Core Contributors

* Fabian Blechschmidt

### Current Status of Project

Complete, but needs to be tested in the wild. If there are problems, just open an issue, we'll have a look on it.
