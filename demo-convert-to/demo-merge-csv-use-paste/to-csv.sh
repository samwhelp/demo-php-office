#!/usr/bin/env bash

localc --headless --convert-to csv:"Text - txt - csv (StarCalc)":44,34,76,,,,true 1.ods

localc --headless --convert-to csv:"Text - txt - csv (StarCalc)":44,34,76,,,,true,,,true 3.ods

awk -F ',' '{print $3}' 3.csv > 2.csv
