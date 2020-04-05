# NekoNeko Nginx KeijiBan
This is a simple bulletin board created to test the function of Nginx.

Features currently being tested are
- Change the root directory to access for each URI
- Combining Nginx with PHP-fpm
- Access control for each URI

## Nginx Setting
Set the following content in an appropriate location.

Also, describe the contents of the "server_name" directive in the "/etc/hosts" file.
```
server {
    listen 8888;
    server_name sample-site.com;
    try_files $uri $uri/ /index.php /index.html = 404;
    index index.php index.html;
    root /var/www/html/sample-site;
    access_log /var/log/nginx/sample-site/access_log;
    error_log /var/log/nginx/sample-site/error_log;

    include fastcgi_params;
    fastcgi_split_path_info ^(.+\.php)(/.*)$;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param PATH_INFO $fastcgi_path_info;
    location /README.md {
      return 404;
    }
    location / {
        location ~* \.php(/|$) { # hoge
            if (!-f $document_root$fastcgi_script_name) {
                return 404;
            }
            fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        }
    }
    location /api {
        location ~* \.php(/|$) { # hoge
            if (!-f $document_root$fastcgi_script_name) {
                return 404;
            }
            root /var/www/html/sample-site/src;
            fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        }
    }
    location /src {
        return 404;
    }
    location /image/ {
        root /var/www;
    }
}
```

### Features
- Image path refers to /var/www/image/ .
- URI starting from "/api" refers to "api" in "src" directory, example "/src/api/getPosts.php". However, if accessed directly with a URI starting from "/src", 404 is returned.

## What you need to run this project
- Install Nginx
- Install PHP-fpm
- Allow PHP-fpm to use SQLite
- Perform the above Nginx settings
- Create sqlite file in "/src/sqlite/database.sqlite3".
