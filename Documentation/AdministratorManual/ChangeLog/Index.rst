.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _changelog:

ChangeLog
---------

The following is a very high level overview of the changes in this extension.


.. tabularcolumns:: |r|p{13.7cm}|

=======  ===========================================================================
Version  Changes
=======  ===========================================================================
2.0.x    - Drop support for TYPO3 below 8.7
         - Namespaces are used now
         - Converted all language files from xml to xliff
         - Manual was converted from sxw to rst
         - Backendmodules are based on extbase/fluid
=======  ===========================================================================

.. tabularcolumns:: |r|p{13.7cm}|

===========  =======================================================================
Date         Changes
===========  =======================================================================
2010-02-27   - Made quicklink HTML use TYPO3 for rendering. (thanks Jigal)
             - New function mod to view unique list of blocked IPs. (thanks Myroslav)
             - Made all table views in the backend sortable by table header.
2008-12-19   - Added Javascript to redirect false-positives (human people).
             - The block page is now outputted through TYPO3.
2008-12-14   - Added link to delete all entries from the block log.
             - Handling block entries per IP and not ID. (thanks Jens)
2008-12-13   - Fixed invalid log entries and stopped blocking if no accesskey was set. (thanks Julian)
2008-12-11   - Fixed typo in class.tx_mhhttpbl.php that broke the extension! (thanks Jens)
2008-12-01   - Updated icons and manual to the new layout.
2008-06-07   - Initial release
===========  =======================================================================
