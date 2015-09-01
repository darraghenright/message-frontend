# Message Frontend

* Author: Darragh Enright <darraghenright@gmail.com>
* Date: 2015-08-31

## Description

As a component of the **Market Trade Processor**, the **Message Frontend** provides a user interface to render received data. The Message Frontend requests data in JSON format from the **Message Processor**.

### Visualisations

* Countries - displays rollup of Trade Messages received from *originating countries* in doughnut and table format.
* Messages - displays timeseries of all Trade Messages received per day with total for period.
* Rates - displays timeseries of EUR rates over time against AUD, CAD, GBP and USD.

A Range select featuring options *Last 7 days*, *Last 14 days*, *Last 30 days* and *All time* redraws the data for the chosen period. For speed, data is served in a format that allows the application to slice and redraw the period without a subsequent request. The user may refresh the request with the *Refres* button, which reloads the page.

## Implementation

### Development

Message Frontend is an AngularJS application. Bower is required to install required packages and dependencies. Perform the following steps to initialise the application:

* Clone the repository
* Run `bower install`

This will install packages `angular`, `bootstrap` and `c3` to path `vendor`. See `component.json` and `.bowerrc`for more details.

To serve locally, run PHP local server in the project root directory, on a port of your choice; e.g:

```
php -S localhost:9999
```
