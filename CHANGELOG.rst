=======================
OpenXPort Release Notes
=======================

.. contents:: Topics

v1.7.2
======

Release summary
---------------
Fix warning related to custom properties of Calendar Link

Details
-------
* Calendars: Fix warning related to custom properties of Link

v1.7.1
======

Release summary
---------------
Hotfix to parse Microsoft Exchange vCards

Details
-------
* Return null in case no alt encoding was specified #6453

v1.7.0
======

Release summary
---------------
Adds more properties to Session, Contacts and Calendar classes

Details
-------
* Do not print properties with null or empty values
* Always return empty state
* Fill in more values for the Session object for stricter clients #6173
* Extend Account class #5120
* Support configuring ErrorHandler output verbosity #6052
* Contacts: Add/fix various properties #6120
* Calendars: Add /set Methods for Calendar and CalendarEvent #6088

v1.6.0
======

Release summary
---------------
Includes a variety of fixes, brings support for AddressBook/set

Details
-------
* Split compound expressions for PHP < 7 #5867
* Fix error handling #6140
* Contacts: Support AddressBook/set (destroy and create) #6120
* Fix a bunch of warnings found during testing
* Support both JMAP Contact and jscontact capability if jscontact is configured

v1.5.0
======

Release summary
---------------
Support full JSCalendar deserialization and add a new way to use the error handler.

Details
-------
* Add method that does not return serialized JSON #5561
* Appointments: Add missing JSCalendar properties #6047
* Appointments: Proper deserialization #5994
* Tests: Add sample hosts file for Ansible integration tests

v1.4.0
======

Release summary
---------------
Support VacationResponse custom capability

Details
-------
* Add timeBetweenResponses to VacationResponse via custom capability #6065

v1.3.0
======

Release summary
---------------
Add support for VacationResponse/get and Preferences/get

Details
-------
* Pin PSR/Log to version 1 for PHP < 8 compatibility
* Implement support for VacationResponse/get method #6018
* Add support for Preferences/get #6021

v1.2.2
=======

Release summary
---------------
Split OXP into separate components

Details
-------
* Verify checksum for composer installer script
* Set Content-Type to JSON of Response
* Fix issue with GELF\Logger on PHP 7

v1.2.0
=======

Release Summary
---------------
Next generation logging and configuration.

Details
-------
* Next-generation logging with more detail and more messages ( #5441 ):
* Add debug capability and ArrayLogger ( #5687 )
* Include Session State in Session response
* Make capabilities configurable
* Move log initialization to OXP
* Contacts: Introduce new optional JSContact-based capability ( #5663 )

v1.1.2
=======

Release Summary
---------------
Fixes some write issues

Details
-------
* VCard Contacts: Fix some write issues

v1.1.1
=======

Release Summary
---------------
Experimental support for SieveScript upload

Details
-------
* Add experimental support for SieveScript upload

v0.12.6
=======

Release Summary
---------------
Escape unicode

Details
-------
* Escape unicode in JSON response
* Contacts: Use AdapterUtil in Address class

v0.12.5
=======

Release Summary
---------------
Improve encoding sanitization

Details
-------
* Throw error if unable to reencode (instead of handling it, potentially swallowing chars)
* Only execute webmailer-specific callback after failed JSON encode

v0.12.4
=======

Release Summary
---------------
Support encoding sanitization

Details
-------
* Reencode free text values on JSON encoding failure #5735

v0.12.0
=======

Release Summary
---------------
Minor build process change

Details
-------
* Restructure Makefile a bit

v0.11.3
=======

Release Summary
---------------
Simpler build process

Details
-------
* Use makefile and composer for building archives

v0.11.0
=======

Release Summary
---------------
Various fixes and logging improvements

Details
-------
* Log PHP Warnings and Errors #5439
* Return 500 on generic errors #5203

v0.10.0
=======

Release Summary
---------------
Adds logging

Details
-------
* Use correct name for invalidArguments error #5454
* Add Logging #5441

v0.8.0
======

Release Summary
---------------
Throw JSON encoding errors

Details
-------
* Throw Exception on JSON encoding errors #5287

v0.7.0
======

Release Summary
---------------
Fix NDay format

Details
-------
* correct nday format
