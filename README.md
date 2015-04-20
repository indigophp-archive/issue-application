# Indigo Service application

[![Latest Version](https://img.shields.io/github/release/indigophp/service-application.svg?style=flat-square)](https://github.com/indigophp/service-application/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/indigophp/service-application.svg?style=flat-square)](https://travis-ci.org/indigophp/service-application)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/indigophp/service-application.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/service-application)
[![Quality Score](https://img.shields.io/scrutinizer/g/indigophp/service-application.svg?style=flat-square)](https://scrutinizer-ci.com/g/indigophp/service-application)
[![HHVM Status](https://img.shields.io/hhvm/indigophp/service-application.svg?style=flat-square)](http://hhvm.h4cc.de/package/indigophp/service-application)
[![Total Downloads](https://img.shields.io/packagist/dt/indigophp/service-application.svg?style=flat-square)](https://packagist.org/packages/indigophp/service-application)

**Handle service cases easily.**


## Install

Via Composer

``` bash
$ composer create-project indigophp/service-application
```


## Usage

1. Create a `.env` file based on the example
2. Create an `app/parameters.yml` file based on the example
3. Create a database
4. Create database schema by running `robo orm:schema-create`
5. Add a user: `robo user:create username email@domain.com password`
6. Start webserver by running `robo server`
7. Enjoy!


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/indigophp/service-application/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
