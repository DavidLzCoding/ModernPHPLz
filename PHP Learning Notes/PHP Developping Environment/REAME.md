# PHP Developping Environment

## Configuring Phpstorm

### PHP cli interpreter configuration

The cli interpreter is a command line interpreter. With a command line interpreter, we can run and debug php files in terminals.

The Configuration pages about cli interpreter:

![img_2.png](img_2.png)

![img.png](img.png)

The php cli interpreter run command page, simply we run ```php.exe a.php```

![img_1.png](img_1.png)


### php built-in webserver configuration

The built-in webserver is a phpstorm tool which can deploy and debug php code on built-in webserver.Please configure it like:

![img_3.png](img_3.png)

The php built-in webserver running sample, simply using command like ```php.exe -S localhost:80  root_directory```:

![img_4.png](img_4.png)

### php xdebug configuration
Firstly, add new configuring lines in php.ini file.
The most important configurations is :
- xdebug.remote_port
- xdebug.remote_enable=On
- xdebug.remote_host="127.0.0.1"

![img_7.png](img_7.png)

Check Xdebug is open through phpinfo(), like:

![img_8.png](img_8.png)


Secondly, configuring the xdebug port in phpstorm:

![img_5.png](img_5.png)

Lastly, add php web-page run-time configuration:

![img_9.png](img_9.png)

![img_10.png](img_10.png)

Set any breakpoints you want, and open the browser, the xdebug will be awake.

![img_11.png](img_11.png)

Tips:  
Set max_execute_time in php.ini will help you to prevent gateway time exceed error through xdebug:

![img_12.png](img_12.png)

