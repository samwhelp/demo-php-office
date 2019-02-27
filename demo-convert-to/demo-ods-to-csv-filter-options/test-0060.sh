#!/usr/bin/env bash

localc --headless --convert-to csv:"Text - txt - csv (StarCalc)":44,34,76,,,,true,,,true demo.ods
# 「Filter_Options」的第10個欄位設為「true」，則會保留「公式(formulas)」。

# 下面網址只有提到第9個欄位。
# https://wiki.openoffice.org/wiki/Documentation/DevGuide/Spreadsheets/Filter_Options

## 第10個欄位的用法，是下載「libreoffice」的「Source Package」所探索到的。
## https://packages.ubuntu.com/bionic/libreoffice
## https://packages.ubuntu.com/source/bionic/libreoffice
# apt-get source libreoffice
# cd libreoffice-6.0.7

# grep 'Save cell formulas'  ./ -R -i -n
# ./sc/source/ui/dbgui/asciiopt.cxx:199:    // 10th token is used for "Save cell formulas" in export options
# ./sc/source/ui/dbgui/asciiopt.cxx:261:    // 10th token is used for "Save cell formulas" in export options

# grep 'Save cell' ./ -R -i -n
