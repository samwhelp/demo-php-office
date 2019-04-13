#!/usr/bin/awk -f
BEGIN {
	## 用「,」拆解欄位
	FS=",";
}
{
	## 排除 第四個欄位是0的
	if ($4 != 0) {
		print $0
		#printf("%s,%s,%s,%s\n", $1, $2, $3, $4)
	}
}
END {

}
