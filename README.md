## Overview

This is a Magento 2 bug fixing module for https://github.com/Worldpay/worldpay-magento2.

- Supported Versions: Magento 2.2 and Magento 2.3
- Tested Version For Worldpay/worldpay-magento2: 2.0.30 

## Pre-Requisite
### Install WorldPay Magento 2 Module

1. Install WorldPay Magento2 module from 
https://github.com/Worldpay/worldpay-magento2

2. Install required library module for WorldPay
https://github.com/Worldpay/worldpay-lib-php

#####Run
composer require worldpay/worldpay-lib-php

## Installation of these fixes 

Extract the zip file on top of Worldpay/worldpay-magento2 files from previous steps

Then execute the setup upgrade commands

php bin/magento setup:upgrade
php bin/magento setup:di:compile

## Fixes Included

##### 1. Missing order confirmation email
Order confirmation Emails are not sent when orders are placed using the extension https://github.com/Worldpay/worldpay-magento2
 
##### 2. Multi Site Support
 https://github.com/Worldpay/worldpay-magento2 module is not supported for multi-site. For example: Different Client / Server key cannot be used. 
 
 This has been fixed in this module.
 
##### 3. Refund online from Magento Admin does not work
Refund online does not work from admin, has been fixed.
 