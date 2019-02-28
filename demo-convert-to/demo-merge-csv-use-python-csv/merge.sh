#!/usr/bin/env bash

./merge.py

localc --headless --convert-to ods final.csv
