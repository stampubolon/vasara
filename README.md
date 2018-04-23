# Vasara
Vasara (finnish: hammer) Extract postman json file for easy access by user and ignore unused element of postman.

## Getting Started
This package use for laravel only (lumen not tested yet). Extracting a single postman json file to an object. Separate postman value to info, item, and event. All element postman route located in item.

### Install
Install this package with composer using command below.
```
composer require dyned/vasara
```

### How to use
Instantiate a vasara object with postman json content.
```
$vasara = new Vasara($postmanJson);
```
Or
You can create it by access file directly using laravel File Facades.
```
$file = File::get('/path/to/postman/json/file.json');

$vasara = new Vasara($file);
```
Check postman item existence to return laravel abort function.
```
if ( ! $vasara->itemExist()) {
    abort(404, 'Postman item not found');
}
```

Retrieve all routes from postman.
```
$vasara->getRoutes();
```

### Another functions
* Retrieve all postman informations.
    ```
    $vasara->getPostmanInfo();
    ```
    
* Retireve all postman items
    ```
    $vasara->getPostmanItem();
    ```

* Retrieve all postman events.
    ```
    $vasara->getPostmanEvent();
    ```

* Change host of postman url path
    ```
    $vasara->changeHost('http://localhost:8000');
    ```

### Return value
```
Collection {#2343 ▼
  #items: array:18 [▼
    0 => {#200 ▼
      +"name": "[Auth] Login"
      +"description": "Retrieve user token"
      +"method": "POST"
      +"header": "[]"
      +"body": "{"email":"email@example.com","password":"secret"}"
      +"url": {#2344 ▼
        +"host": "http://localhost:8000"
        +"path": "auth/login"
        +"full": "http://localhost:8000/auth/login"
      }
    }
    1 => {#2345 ▶}
    2 => {#2347 ▶}
    3 => {#2349 ▶}
    4 => {#2351 ▶}
    5 => {#2353 ▶}
    6 => {#2355 ▶}
    7 => {#2357 ▶}
    8 => {#2359 ▶}
    9 => {#2361 ▶}
    10 => {#2363 ▶}
    11 => {#2365 ▶}
    12 => {#2367 ▶}
    13 => {#2369 ▶}
    14 => {#2371 ▶}
    15 => {#2373 ▶}
    16 => {#2375 ▶}
    17 => {#2377 ▶}
  ]
}
```


## Authors
* **Sabar Tampubolon** - *Initial work* - [stampubolon](https://github.com/stampubolon)

## Owner
This package published on behalf of [DynEd International, Inc](https://www.dyned.com/).

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

