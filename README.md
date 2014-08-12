In Summary
--------------
Full Stack app that can:

1. have an interface to search for buses near an area
2. know when the buses arrive at a specific bus stop from an API

*Bus timings, locations in this project are fake and is meant for evaluation and educational purposes only*.

**Live example: [https://buswhere.mosufy.com/](https://buswhere.mosufy.com/)**

Test the app by entering "Plaza Singapura" or "Bugis Junction".

Bus timings will always return 'NA' as the timing will most likely would have expired. Change the schedule on the database to see for yourself.

Technology Stack
--------------
- Amazon Linux AMI
- Apache 2.4
- PHP 5.5
- MySQL 5.5
- Back-end
    - Custom PHP MVC (https://github.com/mosufy/php-mvc)
    - Composer
    - Search-engine-friendly URL structure
    - Memcached
    - Service-oriented Architecture (RESTful API)
    - HTTP API Authentication using HMAC (hash) with timestamp validation
- Front-end
    - HTML
    - CSS
    - CSS Media Queries
    - JQuery
    - AJAX
    - Responsive Design

Intallation
--------------
1. Create config.php from sample.config.php in /application/config/
2. Run Composer to install dependencies
3. Ensure /application/tmp/ directories and child directories given write-permission to apache
4. Install MySQL database using /application/_install/1-create-and-insert-table-into-db.sql

API references
--------------
Base URL

    https://buswhere.mosufy.com/api

Check LIVE status of app

    [GET] /v1/ping
  
Signature validation

    [GET] /v1/check
  
Fetch bus stop data with bus services list

    [GET] /v1/bus_stops/{bus_stopID}
  
Search for place by name (ASCII characters only)

    [GET] /v1/places?q=name%20of%20place
  
Fetch place data

    [GET] /v1/places/{placeID}
  
Fetch list of bus services near place_id

    [GET] /v1/services/nearby/{placeID}?distance={int_in_km}
  
Fetch list of bus services near your location

    [GET] /v1/services/radial?lat={latitude}&lon={longitude}
  
Fetch next bus arrival time in minutes

    [GET] /v1/schedules/arrival_time/{bus_serviceID}/{bus_stopID}