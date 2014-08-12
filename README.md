Bus Where app
==============

In Summary
--------------
Full Stack app that can:

1. have an interface to search for buses near an area
2. know when the buses arrive at a specific bus stop from an API

*Bus timings, locations in this project are fake and is meant for evaluation and educational purposes only*.

Live example: [https://buswhere.mosufy.com/](https://buswhere.mosufy.com/)

Technology used
--------------
- Amazon Linux AMI
- Apache 2.4
- PHP 5.5
- MySQL 5.5
- Service-Oriented Architecture (RESTful API)
- HTTP API Authentication using HMAC (hash) with timestamp validation

Intallation
--------------
1. Create config.php from sample.config.php in /application/config/
2. Run Composer to install dependencies
3. Ensure /application/tmp/ directories and child directories give write-permission to apache
4. Install MySQL database using /application/_install/1-create-and-insert-table-into-db.sql

API references
--------------
Base URL
  https://buswhere.mosufy.com/api

[GET] Check LIVE status of app
  /v1/ping
  
[GET] Signature validation
  /v1/check
  
[GET] Fetch bus stop data with bus services list
  /v1/bus_stops/{stop_id}
  
[GET] Search for place by name (ASCII characters only)
  /v1/places?q={name}%20{of}%20{place}
  
[GET] Fetch place data
  /v1/places/{place_id}
  
[GET] Fetch list of bus services near place_id
  /v1/services/nearby/{place_id}?distance={int_in_km}
  
[GET] Fetch list of bus services near your location
  /v1/services/radial?lat={latitude}&lon={longitude}
  
[GET] Fetch next bus arrival time in minutes
  /v1/schedules/arrival_time/{bus_id}/{stop_id}