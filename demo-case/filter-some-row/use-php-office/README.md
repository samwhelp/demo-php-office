
# 過濾範例


## 主要程式碼

* [main.php](main.php)


## 前置作業

### 安裝「phpoffice/phpspreadsheet」

若您已經有安裝「composer」了，

我也是事先寫好「[composer.json](composer.json)」。

可以執行下面指令

``` sh
$ composer install
```

順利的話，就會產生一個資料夾「vendor」以及檔案「composer.lock」。

上面的指令，我寫在「[install.sh](install.sh)」裡，所以也可以直接執行下面指令安裝。

``` sh
$ ./install.sh
```

或是也可以參考下面的網址來了解這部份

* https://phpspreadsheet.readthedocs.io/en/latest/#installation
* https://packagist.org/packages/phpoffice/phpspreadsheet


## 注意事項

若沒有安裝「composer」，可以參考「[我安裝composer的方式](../../demo-install-composer/ex-install-composer)」。

若要使用「composer」，必須事先安裝「php-cli」，可以參考「[我安裝php-cli的方式](../../demo-install-php-cli/ex-install-php-cli)」。

若要安裝「phpoffice/phpspreadsheet」，必須事先安裝一些所需要的「php-extension」，可以參考「[我安裝的方式](../../demo-install-php-cli/ex-install-php-ext-for-php-spreadsheet)」。


## 這個程式的用法

執行

``` sh
$ ./main.php data/input.ods var/output.ods
```

就會產生一個檔案「var/output.ods」，這是過濾後的結果。

上面的指令，我寫在「[run.sh](run.sh)」裡，所以也可以直接執行下面指令。

``` sh
$ ./run.sh
```
