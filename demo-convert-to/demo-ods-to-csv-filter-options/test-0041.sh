#!/usr/bin/env bash

localc --headless --convert-to csv:"Text - txt - csv (StarCalc)":44,34,76 demo.ods

# https://wiki.openoffice.org/wiki/Documentation/DevGuide/Spreadsheets/Filter_Options#Examples
# https://wiki.openoffice.org/wiki/Documentation/DevGuide/Spreadsheets/Filter_Options#Tokens_1_to_5
# https://wiki.openoffice.org/wiki/Documentation/DevGuide/Spreadsheets/Filter_Options#Filter_Options_for_Lotus.2C_dBase_and_DIF_Filters
# 「76」代表著「Character Set」是「Unicode (UTF-8) 」
