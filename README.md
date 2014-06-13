# Using the PHP connector

The php connector currently removes the default debugging logic and replaces it with a logger to oohLaLog.
You only need set up the API key to be good to go.

### Global variables to set

* oohLaLogApiKey
* OLL_LOG_FILE _(optional)_
  * Defauls to /usr/local/php/error.log
* OLL_LOG_LEVEL
  * works like linux permissions
  * (1 = error,2 = warning,4 = info)
  * defaults to 3 (error,warning)
* OLL_PRINT_ERRORS _boolean_ (defaults to true)
 
### Usage
at the top of each script (or in a file that is included everywhere)

```php
$oohLaLogApiKey = 'XXX-XXXXXX-XXX-XX';
require('oohLaLogger.php');
```

anything that happens before the require will not be sent to oohlalog
 
### Limitations

Currently uses the exec command to fork a curl process, you dont get a response but it no longer blocks in php while running