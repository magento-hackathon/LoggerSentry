# Magento To Sentry Logger

The purpose of this project is to log the magento error and exception messages to sentry, too. This extension is an extension of the [Firegento Logger module](https://github.com/firegento/firegento-logger), so you need the Logger module to use the Sentry logger.

# Installation
## Installing Without Composer
If you're not using composer to manage non-magento 3rd party packages, then you can install simply by:
1. Pull down the code somewhere (`git clone git@github.com:magento-hackathon/LoggerSentry.git`)
2. Copy over all files associatively.
3. Configure the module (see below).

## Installtion With Composer
For those of you that want to keep 3rd party packages out of your repo, here are your instructions:
1. Add `"sentry/sentry": "^1.6.0"` to your `composer.json` in the `require` section.
2. Run `composer update` to update libraries.
3. Pull down the code somewhere (`git clone git@github.com:magento-hackathon/LoggerSentry.git`)
4. Copy over all files associatively.
5. Delete `lib/` from the LoggerSentry folder (or wherever you just pulled down the code)
6. Configure the module (see below).

## Configuration

After you install the module you can configure it in the backend at: `System > Configuration > Advanced > FireGento Logger > Sentry Logger`

## Further Information

### Core Contributors

* Fabian Blechschmidt

### Current Status of Project

Complete, but needs to be tested in the wild. If there are problems, just open an issue, we'll have a look on it.
