# Message Frontend

* Author: Darragh Enright <darraghenright@gmail.com>
* Date: 2015-08-31

## Description

As a component of the **Market Trade Processor**, the **Message Frontend** provides a user interface to render received data.

## Implementation

### Development

Message Frontend is an AngularJS application. Bower is required to install required packages and dependencies. Perform the following steps to initialise the application:

* Clone the repository
* Run `bower install`

This will install packages `angular`, `bootstrap` and `c3` to path `vendor`. See `component.json` and `.bowerrc`for more details.

To serve locally, run PHP local server in the project root directory, as follows:

```
php -S localhost:9999
```
