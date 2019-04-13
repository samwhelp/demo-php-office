#!/usr/bin/env bash

## 一行的寫法
awk -F ',' '{ if ($4 != 0) { print $0 } }' "var/input.csv" > "var/output.csv"

## 下面的寫法，將上面的寫法，寫在檔案「main.awk」，當成「Script」來使用
#./main.awk var/input.csv > var/output.csv
