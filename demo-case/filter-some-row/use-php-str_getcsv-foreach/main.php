#!/usr/bin/env php
<?php

	function save_csv ($file, $data=array())
	{
		//var_dump($data);

		//https://www.php.net/manual/en/function.fputcsv.php

		// https://www.php.net/manual/en/function.fopen.php
		// 開檔
		if (($fp = fopen($file, 'w')) === FALSE) { //若開檔失敗，就直接離開，不做下面的處理。
			return FALSE;
		}

		// 將資料一行一行的寫入剛剛開啟的檔案。
		foreach ((array)$data as $index => $cells) {
			//var_dump($cells);

			//https://www.php.net/manual/en/function.fputcsv.php
			fputcsv($fp, (array)$cells);
		}

		fclose($fp);

		return TRUE;
	}


	function load_csv ($file)
	{
		// https://www.php.net/manual/en/function.file-exists.php
		if (!file_exists($file)) { //檔案不存在，直接回傳空的陣列。
			return [];
		}

		// https://www.php.net/manual/en/function.str-getcsv.php#114764
		$data = array_map('str_getcsv', file($file)); //將整個csv檔載入。

		//https://www.php.net/manual/en/function.array-shift.php
		//array_shift($data); # remove column header //排除第一行，這裡因為要留著，所以不做這個動作

		return $data;
	}

	function main ()
	{
		$input_csv = __DIR__ . '/var/input.csv';
		$output_csv = __DIR__ . '/var/output.csv';

		if (!file_exists($input_csv)) { //檢查檔案「var/input.csv」是否存在
			echo '檔案不存在：' . $input_csv;
			echo PHP_EOL;
			return; // 因為檔案不存在，所以直接離開，不做下面的處理。
		}

		$source_data = load_csv($input_csv); // 載入「var/input.csv」

		//https://www.php.net/manual/en/function.var-dump.php
		//var_dump($list); ## 把資料 dump出來，除錯用

		$target_data = []; // 新的資料儲存處，用來紀錄想要的那幾列(row)

		// https://www.php.net/manual/en/control-structures.foreach.php
		foreach ($source_data as $index => $cells) {

			//var_dump($cells);


			// https://www.php.net/manual/en/control-structures.if.php
			// https://www.php.net/manual/en/language.operators.comparison.php

			if ($cells['3'] == '0') { // 排除 欄位 '3' 是 0 的 那一列(row)
				continue;
			}

			// https://www.php.net/manual/en/function.array-push.php
			//array_push($target_data, $cells);
			$target_data[] = $cells;
		}

		//var_dump($target_data);

		save_csv($output_csv, $target_data); // 將新的資料「$target_data」，寫入「var/input.csv」
	}


	main();
