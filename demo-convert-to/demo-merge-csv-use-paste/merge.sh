#!/usr/bin/env bash

paste -d',' 1.csv 2.csv > final.csv

localc --headless --convert-to ods final.csv
