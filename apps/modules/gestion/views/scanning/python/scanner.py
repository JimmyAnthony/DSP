#!/usr/bin/env python

from simple_base import TwainBase

ID_EXIT=102
ID_OPEN_SCANNER=103
ID_ACQUIRE_NATIVELY=104
ID_SCROLLEDWINDOW1=105
ID_BMPIMAGE=106
ID_ACQUIRE_BY_FILE=107
ID_TIMER=108

# You can either Poll the TWAIN source, or process the scanned image in an
# event callback. The event callback has not been fully tested using GTK.
# Specifically this does not work with Tkinter.
USE_CALLBACK=True

