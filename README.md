ready2order PHP API
=============

ready2order PHP API v1 is a PHP-wrapper for simply using ready2order API api.ready2order.at

Installation
------------

You can install ready2order-php-api-v1 with composer

```
composer require duxthefux/ready2order-php-api-v1
```

You will then need to:
* run ``composer install`` to get these dependencies added to your vendor directory
* add the autoloader to your application with this line: ``require("vendor/autoload.php")``

Alternatively you can just download the ready2orderAPI.php file and include it manually:

```php
include('./ready2orderAPI.php');
```

Examples
--------

Get client data

```php
use \ready2order\ready2orderAPI;

$ready2orderAPI = new ready2orderAPI('user-token');
print_r($ready2orderAPI->get('company'));
```

Insert new productgroup with one product

```php
use \ready2order\ready2orderAPI;

$ready2order = new ready2orderAPI(getenv('R2O_USER_TOKEN'));

// INSERT PRODUCTGROUP
$productGroup = $ready2order->put('productgroups',array(
    "productgroup_name" => "PHPUnit Testproductgroup"
));
$this->assertArrayHasKey("productgroup_name",$productGroup);


// INSERT PRODUCT
$product = $ready2order->put('products',array(
        "product_name" => "Cupcake",
        "product_price" => 5.2,
        "product_vat" => 20,
        "productgroup" => array(
            "productgroup_id" => $productGroup["productgroup_id"]
        )
));
```


Thanks to Drew McLellan's drewm/mailchimp-api
--------
 * Thanks to Drew McLellan for creating drewm/mailchimp-api (https://github.com/drewm/mailchimp-api)
 * The PHP library was written by Dew McLellan and "forked" for using ready2order API because it's just super simple
 * Drew McLellan <drew.mclellan@gmail.com>
