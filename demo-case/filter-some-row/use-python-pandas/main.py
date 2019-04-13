#!/usr/bin/env python3

## 來自討論串 https://www.facebook.com/groups/ubuntu.zh.hant/permalink/2553986081323365/
## 使用前先安裝
## sudo apt-get install python3-pandas

import pandas as pd

df = pd.read_csv("var/input.csv")
df[df.bal != 0].to_csv("var/output.csv", index=False)
