

## 緣起

從下面的討論看到了「localc --convert-to」的用法，

* https://www.facebook.com/groups/ubuntu.zh.hant/permalink/2480940128627961/
* https://www.facebook.com/groups/ubuntu.zh.hant/permalink/2486647224723918/

以下紀錄了一些額外的探索過程。


## Manpage

* $ man [localc](http://manpages.ubuntu.com/manpages/bionic/en/man1/localc.1.html)
* $ man [loffice](http://manpages.ubuntu.com/manpages/bionic/en/man1/loffice.1.html)
* $ man [libreoffice](http://manpages.ubuntu.com/manpages/bionic/en/man1/libreoffice.1.html)

可以找到下面的說明

```
--convert-to output_file_extension[:output_filter_name] [--outdir output_dir] file...
	   Batch converts files.  If --outdir is not specified then the current working directory is used as the output directory for  the  con‐
	   verted files. It implies --headless.

	   Examples:

	   --convert-to pdf *.doc

	   Converts all .doc files to PDFs.

	   --convert-to pdf:writer_pdf_Export --outdir /home/user *.doc

	   Converts all .doc files to PDFs using the settings in the Writer PDF export dialog and saving them in /home/user.
```


## Filter Options

### 第 1 ~ 9 個 欄位

* https://wiki.openoffice.org/wiki/Documentation/DevGuide/Spreadsheets/Filter_Options
* https://wiki.openoffice.org/wiki/Documentation/DevGuide/OfficeDev/Filter_Options

### 第 10 個欄位 (保留公式)

* https://github.com/LibreOffice/core/blob/distro/cib/libreoffice-6-0/sc/source/ui/dbgui/asciiopt.cxx#L199
* https://github.com/LibreOffice/core/blob/distro/cib/libreoffice-6-0/sc/source/ui/dbgui/asciiopt.cxx#L261

請參考「[test-0060.sh](test-0060.sh)」。

而「Filter Options」也可以套用在「[unoconv](http://manpages.ubuntu.com/manpages/bionic/en/man1/unoconv.1.html)」，請參考「[demo-ods-to-csv-use-unoconv](../demo-ods-to-csv-use-unoconv) / [test-0020.sh](../demo-ods-to-csv-use-unoconv/test-0020.sh)」。


## Explore

## 探索一

執行下面指令，下載「[libreoffice](https://packages.ubuntu.com/bionic/libreoffice)」的「Source Package: [libreoffice](https://packages.ubuntu.com/source/bionic/libreoffice)」。

``` sh
$ apt-get source libreoffice
```

執行下面指令，切換到「libreoffice-6.0.7」這個資料夾。

``` sh
cd libreoffice-6.0.7
```

使用「Save cell formulas」當關鍵字探索，執行下面指令

``` sh
$ grep 'Save cell formulas'  ./ -R -i -n
```

顯示

```
./sc/source/ui/dbgui/asciiopt.cxx:199:    // 10th token is used for "Save cell formulas" in export options
./sc/source/ui/dbgui/asciiopt.cxx:261:    // 10th token is used for "Save cell formulas" in export options
```

對照上面的「第 10 個欄位 (保留公式)」列的連結來看。

使用「Save cell」當關鍵字探索，執行下面指令

``` sh
$ grep 'Save cell' ./ -R -i -n
```

顯示結果很長，就不貼上來了。


## 探索二

執行

``` sh
$ which localc
```

顯示

``` sh
/usr/bin/localc
```

執行

``` sh
$ file /usr/bin/localc
```

或是執行

``` sh
$ file $(which localc)
```

顯示

```
/usr/bin/localc: POSIX shell script, ASCII text executable
```

執行

``` sh
$ cat /usr/bin/localc
```

或是執行

``` sh
$ cat $(which localc)
```

顯示

```
#!/bin/sh
/usr/lib/libreoffice/program/soffice --calc "$@"
```

執行

``` sh
$ dpkg -S $(which localc)
```

或是執行

``` sh
$ dpkg -S /usr/bin/localc
```

顯示

```
libreoffice-calc: /usr/bin/localc
```

執行

``` sh
$ dpkg -S /usr/lib/libreoffice/program/soffice
```

顯示

```
libreoffice-common: /usr/lib/libreoffice/program/soffice
```

執行

``` sh
$ dpkg -S $(which libreoffice)
```

顯示

```
libreoffice-common: /usr/bin/libreoffice
```

執行

``` sh
$ dpkg -S $(which loffice)
```

顯示

```
libreoffice-common: /usr/bin/loffice
```

執行

``` sh
$ cat /usr/bin/loffice
```

顯示

```
#!/bin/sh
/usr/lib/libreoffice/program/soffice  "$@"
```

執行

``` sh
$ file /usr/bin/libreoffice
```

顯示

```
/usr/bin/libreoffice: symbolic link to ../lib/libreoffice/program/soffice
```

執行

``` sh
$ cat /usr/bin/libreoffice
```

或是執行

``` sh
$ cat /usr/lib/libreoffice/program/soffice
```

顯示很多，就不貼上來了。
