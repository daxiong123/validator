# Validator - The data format validation

[![Build Status](https://travis-ci.org/daxiong123/validator.svg?branch=master)](https://travis-ci.org/daxiong123/validator)

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)

---

### Installation

To install Validator, simply:

    $ composer require 5ichong/validator

For latest commit version:

    $ composer require 5ichong/validator @dev

### Requirements

Validator works with PHP 5.6, 7.0, 7.1.

### Quick Start and Examples

```php
require __DIR__ . '/vendor/autoload.php';

use \Aichong\Validator;

$curl = new Validator();
$validator->validate(['test' => ''], ['test' => 'required'], ['test' => 'empty']);
$validator->validate(['test' => '1'], ['test' => 'equals:1'], ['test' => 'noequals']);
$validator->validate(['test' => '123'], ['test' => 'length:3'], ['test' => 'nolength']);
$validator->validate(['test' => '15821789646'], ['test' => 'phone'], ['test' => 'nophone'])

```



