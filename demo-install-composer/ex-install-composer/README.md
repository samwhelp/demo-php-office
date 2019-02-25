
# 安裝「composer」範例


## 說明

這裡安裝的方式是採用「Manual Download」。

根據下面的頁面

* [https://getcomposer.org/download/](https://getcomposer.org/download/)

可以找到「[Latest Snapshot](https://getcomposer.org/composer.phar)」這個字樣，也就是可以找到下面的網址

* [https://getcomposer.org/composer.phar](https://getcomposer.org/composer.phar)

所以就可以將它下載下來，並且放到「~/bin」這個資料夾，並且重新命名為「composer」。

以下是參考步驟，完整的步驟則是寫在「[install.sh](install.sh)」。


## 產生資料夾「~/bin」

執行下面指令，產生資料夾「~/bin」。

``` sh
$ mkdir -p "$HOME/bin"
```

## 下載「composer.phar」放到「~/bin/composer」

執行下面指令，下載「composer.phar」，並且放到「~/bin/composer」。

``` sh
$ wget -c 'https://getcomposer.org/composer.phar' -O "$HOME/bin/composer"
```

## 設定「~/bin/composer」可執行

執行下面指令，設定「~/bin/composer」可執行。

``` sh
$ chmod u+x "$HOME/bin/composer"
```

## 更新「~/bin/composer」

執行下面指令，將「~/bin/composer」更新到最新的版本。

``` sh
"$HOME/bin/composer" self-update
```
