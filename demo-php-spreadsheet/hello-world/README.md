
# Hello World 範例

## 安裝「phpoffice/phpspreadsheet」

參考下面這個網址

* https://phpspreadsheet.readthedocs.io/en/latest/#installation

若您已經有安裝「composer」了，

可以執行下面指令

``` sh
$ composer require phpoffice/phpspreadsheet
```

順利的話，就會產生一個資料夾「vendor」以及兩個檔案，「composer.json」和「composer.lock」。

上面的指令，我寫在「[install.sh](install.sh)」裡，所以也可以直接執行下面指令安裝。

``` sh
$ ./install.sh
```


## 注意事項

若沒有安裝「composer」，可以參考「[我安裝composer的方式](../../demo-install-composer/ex-install-composer)」。

若要使用「composer」，必須事先安裝「php-cli」，可以參考「[我安裝php-cli的方式](../../demo-install-php-cli/ex-install-php-cli)」。

若要安裝「phpoffice/phpspreadsheet」，必須事先安裝一些所需要的「php-extension」，可以參考「[我安裝的方式](../../demo-install-php-cli/ex-install-php-ext-for-php-spreadsheet)」。


## 第一個程式

參考下面網址

* [https://phpspreadsheet.readthedocs.io/en/latest/#hello-world](https://phpspreadsheet.readthedocs.io/en/latest/#hello-world)

```
#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');

$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');
```

我將上面的「code」寫在「[main.php](main.php)」裡，並當成「script」來使用

所以可以執行

``` sh
$ php main.php
```

或是執行

``` sh
$ ./main.php
```

就會產生一個檔案「hello world.xlsx」。

可以在「File Manager」點選「hello world.xlsx」這個檔案，使用「Libreoffice」開啟這個檔案。

也可以在「Terminal」執行下面指令，來開啟「hello world.xlsx」這個檔案

``` sh
$ localc 'hello world.xlsx'
```
