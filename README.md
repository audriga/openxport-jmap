# OpenXPort Data Portability Framework
The OpenXPort data portability framework simplifies development of an endpoint for data extraction.

It should be simple for consumers to migrate from another service to your service and vice-versa. OpenXPort makes it easy to expose a RESTful API Endpoint for data portability. It is built on top of the interoperable protocol [JMAP](https://jmap.io/), which already supports a wide variety of data types and can be extended for more.

Please note that this version is still in its early stages.

The following data types are currently supported in OpenXPort:

* Contacts over the JMAP for Contacts protocol
* Calendars over the JMAP for Calendars protocol, built on top of the [JSCalendar](https://tools.ietf.org/html/draft-ietf-calext-jscalendar-32) format
* Tasks over the JMAP for Tasks protocol, built on top of the [JSCalendar](https://tools.ietf.org/html/draft-ietf-calext-jscalendar-32) format
* Files over the upcoming JMAP for Files protocol

## Installation
1. Run `composer install --prefer-dist --no-dev`

## Development
### Installation
1. Run `composer install --prefer-dist`
