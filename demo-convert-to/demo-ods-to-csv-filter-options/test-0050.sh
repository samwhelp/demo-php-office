#!/usr/bin/env bash

localc --headless --convert-to csv:"Text - txt - csv (StarCalc)":44,34,76,,,,true demo.ods

# https://wiki.openoffice.org/wiki/Documentation/DevGuide/Spreadsheets/Filter_Options#Token_7.2C_csv_export
# 「Filter_Options」的第7個欄位設為「true」，則文字會被「"」括住。
