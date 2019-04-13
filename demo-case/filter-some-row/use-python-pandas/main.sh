#!/usr/bin/env bash

## 來自討論串 https://www.facebook.com/groups/ubuntu.zh.hant/permalink/2553986081323365/
## 使用前先安裝
## sudo apt-get install python3-pandas
## 一行的寫法
python3 -c 'import pandas as pd;df = pd.read_csv("var/input.csv");df[df.bal != 0].to_csv("var/output.csv", index=False)'

## 下面的寫法，將上面的寫法，寫在檔案「main.py」，當成「Script」來使用
#./main.py
