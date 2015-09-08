## Getting Started

```sh
$ git clone git@github.com:assertchris-tutorials/icicle-http-server.git
$ cd icicle-http-server
$ composer install
$ php server.php
```

You'll also need to create an Apache virtual host, with the following rewrite directives:

```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*) http://%{SERVER_NAME}:9001%{REQUEST_URI} [P]
```

This will transparently forward all requests for missing files to port 9001 (where the icicle server is waiting to receive them).
