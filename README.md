# OpenXPort Data Portability Framework
The OpenXPort data portability framework simplifies development of an endpoint for data migration.

It should be simple for consumers to migrate from another service to your service and vice versa. OpenXPort makes it easy to expose a RESTful API Endpoint for data portability. It is built on top of the interoperable protocol [JMAP](https://jmap.io/), which already supports a wide variety of data types and can be extended for more.

The following data types are currently supported by OpenXPort:

* Signatures over the JMAP for Mail protocol
* Calendars over the JMAP for Calendars protocol, built on top of the [JSCalendar](https://datatracker.ietf.org/doc/html/rfc8984) format
* Contacts over the JMAP for Contacts protocol, built on top of the [JSContact](https://datatracker.ietf.org/doc/draft-ietf-calext-jscontact/) format
* Tasks over the JMAP for Tasks protocol, built on top of the [JSCalendar](https://datatracker.ietf.org/doc/html/rfc8984) format
* SieveScripts over the JMAP for Sieve Scripts protocol
* Files over the upcoming JMAP for Files protocol
* Preferences over the https://www.audriga.eu/jmap/preferences/ Extension

OpenXPort is built with compatibility for older systems in mind. We support all PHP versions down to 5.6 to provide data portability even for older systems.

## Installation
### Local installation
1. Run `make` to initialize the project for the default PHP version (8.1). Use other build targets (e.g. `make php56_mode` or `make php70_mode`) instead, in case you need to build for a different version.

## Development
### Installation
1. Run `make` or one of the targets for old PHP versions above.
1. Run `make update` to update dependencies and make development tools available

### Tests
To run all tests run `make fulltest`. This requires [Podman](https://podman.io/)
(for Static Anaylsis) and [Ansible](https://www.ansible.com/) (for Integration
Tests).

You can also run them separately:

* **Static Analysis** via `make lint`
* **Unit Tests** via `make unit_test`
* **Integration Tests** via `make integration_test` (more info under
`tests/integration/README.md`)