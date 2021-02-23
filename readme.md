##### microframework for api
##### test api requests are @ hello.http file
##### composer update 
- Tested on <b>APACHE PHP 7.4</b>

- basic app workflow 
1. routes.php has routes registered
2. matches to given controller@method
3. method can be injected with FormRequests
which processes validation

- laravel inspired
```
<VirtualHost glofox.local:80>
	ServerName http://glofox.local
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/glofox
        
        <Directory "/var/www/glofox">
                AllowOverride All
                order allow,deny
                allow from all
        </Directory>
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```
# vim: syntax=apache ts=4 sw=4 sts=4 sr noet

