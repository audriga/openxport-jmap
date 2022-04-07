=======================
OpenXPort Release Notes
=======================

.. contents:: Topics

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