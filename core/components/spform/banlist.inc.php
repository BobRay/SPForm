# file: banlist.inc.php
# Version: 3.1.0
# $Revision: 118 $
# $Author: Bob Ray $
# $Date: 2008-10-01 01:12:07 -0500 (Wed, 01 Oct 2008) $
# Banned/blocked email addresses, hosts, domains and IP addresses fpr SPForm.
# One per line.
#
# These are compared to the email address specified in the
# form, the REMOTE_HOST and REMOTE_ADDR, depending on the format.
#
# This section contains EXAMPLEs--showing how it's done.
# Real lines go below without the comment ("#") indicator
#
# .example.com		# Any REMOTE_HOST ending in ".example.com"
# host.example.com	# Any REMOTE_HOST ending in "host.example.com"
# 10.0.0.0		# Exact REMOTE_ADDR IP address
# 192.168			# Any REMOTE_ADDR starting with "192.168"
# user@example.com	# Specifically "user@example.com" in email address
# @example.com		# Any user "@example.com" in email address (kind of)

# The following are real lines:
0.0.0.0
spam@spam.com
nobody@nowhere.com
