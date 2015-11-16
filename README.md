# RestMoji

[Restmoji homepage](http://restmoji.herokuapp.com) ![alt text](http://restmoji.herokuapp.com/favicon.ico)

This is a restful API service provider that enables you to create, edit, retreive and delete emojis.


## Instructions

***Prerequisite software:***

- Install PHP
    [Get](http://php.net/manual/en/install.php)
- Install PECL
    [Get On Mac](http://jason.pureconcepts.net/2012/10/install-pear-pecl-mac-os-x/)

- Install MongoDB PHP Driver
    [Get](https://docs.mongodb.org/ecosystem/drivers/php/)

***Get the code***

Clone the repository

    git clone https://github.com/andela-bmosigisi/restmoji.git

***Install dependencies***

In the root folder, run:

    composer install

***Serve the application***

Using php development server:
    
    php -S localhost:8000 -t public

You can now access the application at localhost:8000

NB: If you are using apache, make sure that you serve the /public directory.


***Running tests:***

    vendor/bin/phpspec run

## Usage

Some restful routes have been provided for managing emojis.

Some routes require authentication while others are publicly accessible.

To get a full listing of routes and their functions, go [here](restmoji.herokuapp.com)

***Getting started***

- Get an auth token [here](restmoji.herokuapp.com)

- For non-publicly accessible routes, include a field whose key is 'token' and value is the value of the token field obtained above.

- An emoji model looks as follows:

```
{
    id: 1,
    name: “Aunty!”,
    char: ​'\U1083',
    keywords:[“raise”, “hands”, “girl”, “woman”],
    category: “people”,
    date_created: “2015-08-12 11:57:23”,
    date_modified: “2015-08-12 11:57:23”,
    created_by: “1342f32-23232dgh-e43bt9”
}
```

***Important notes***

- POST, PATCH and PUT requests expect json data to be passed to the server. Therefore, remember to include this in your request header. 

    'Content-Type'  :   'application/json'

- Keywords should be provided as a comma-separated list of words.

- For POST/PUT requests, [name, char, keywords, category] fields are required.

- Atleast one field is required for PATCH requests.

## License

The MIT License (MIT). Please see [License File](https://opensource.org/licenses/MIT) for more information.