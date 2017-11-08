.. include:: ../Includes.txt
.. include:: Images.txt

.. _introduction:

Introduction
============

.. only:: html

	:ref:`what` | :ref:`whats-new` | :ref:`screenshots`

.. _what:

What does it do?
----------------

Blocks spam bots or other “bad users” listed at httpbl.org.


.. _whats-new:

What's new in http:BL Blocking 2.0?
-----------------------------------

http:BL Blocking 2.0 uses the same data-structure that was created with former versions.
But there was some code-refactoring especially for TYPO3 8.7 LTS and upcoming versions.

Facts
^^^^^

- Code-Refactoring

  - Namespaces will be used now
  - Converted all language files from xml to xliff
  - Manual was converted from sxw to rst
  - Backendmodules are based on extbase/fluid


.. _screenshots:

Screenshots
-----------


Backend: Blacklist
^^^^^^^^^^^^^^^^^^^^^

|backend1|

Manage the blocked IP addresses.


Backend: Whitelist
^^^^^^^^^^^^^^^^^^

|backend2|

Manage some IP addresses as white ones.


Backend: IPs only
^^^^^^^^^^^^^^^^^^

|backend3|

Get an overview over the blocked IP addresses including a link to details on `projecthoneypot.org <http://projecthoneypot.org>`_.
