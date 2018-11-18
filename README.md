Graphic Editor
======

# Requirements

- PHP >= 5.6
- PHP ext's: yaml, json, gd and ctype

# Install

## Local environment

Install php on your local machine based on requirements and run composer:

```bash
$ composer install 
``` 

Run the local server or configure your application server pointing to `public/index.php`

```bash
$ php -S 0.0.0.0:8080 public/index.php
```

## Using Docker

You can use the makefile to create the network, build the application, install composer and run the server.
Just use the following command:

```bash
$ make setup && make run
```

# Request

## Using CURL to create a image

```bash
curl -X POST \
  http://localhost:8080/shape \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: d21e7d2f-6448-45d7-9bd3-a0da9919e919' \
  -d '[
	{
	  "type": "square",
	  "params": {
	  	"height": 100,
	  	"width": 100,
	  	"border_color": "#008000",
	  	"color": "#FFC0CB"
	  }
	}
]'
```

## Using PHP (HttpRequest)

```php
<?php

$request = new HttpRequest();
$request->setUrl('http://localhost:8080/shape');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'Content-Type' => 'application/json'
));

$request->setBody('[
	{
	  "type": "square",
	  "params": {
	  	"height": 100,
	  	"width": 100,
	  	"border_color": "#008000",
	  	"color": "#FFC0CB"
	  }
	}
]');

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}
```
