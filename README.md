# Certinfo

A CLI application that shows Certificate Information of single X509 certificate (PEM and DER format) or multiple certificates (check a directory)

------

## Installation

### Global installation

You can install the binary in global composer directory:

```
composer global require marco-introini/certinfo-cli
```

------

## Usage

All the available commands are visible using:

```
certinfo
```

### Check a single file

```
certinfo certificate:check <filename>
```

_filename_ can be a PEM, CRT, CER or DER file

### Check every file in a directory

```
certinfo certificate:check-dir <directory>
```

------

## Thanks

This package is based on Laravel Zero.

Laravel Zero was created by [Nuno Maduro](https://github.com/nunomaduro) and [Owen Voke](https://github.com/owenvoke), and is a micro-framework that provides an elegant starting point for your console application. It is an **unofficial** and customized version of Laravel optimized for building command-line applications.

------


## Support the development

If you like my work you can buy me a coffee

- via [PayPal](https://paypal.me/marcointroini)

## License

This is an open-source software licensed under the MIT license.
