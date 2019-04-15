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

		// 將資料一列一列的寫入剛剛開啟的檔案。
		foreach ((array)$data as $index => $cells) {
			//var_dump($cells);

			//https://www.php.net/manual/en/function.fputcsv.php
			fputcsv($fp, (array)$cells);
		}

		// https://www.php.net/manual/en/function.fclose.php
		fclose($fp);

		return TRUE;
	}


	function load_csv_and_filter ($file)
	{
		// https://www.php.net/manual/en/function.file-exists.php
		if (!file_exists($file)) { //檔案不存在，直接回傳空的陣列。
			return [];
		}

		// https://www.php.net/manual/en/function.fopen.php
		if (($fp = fopen($file, 'r')) === FALSE) { //若開檔失敗，就直接離開，不做下面的處理。
			return [];
		}

		$data = [];

		// https://www.php.net/manual/en/function.fgetcsv.php
		while (($cells = fgetcsv($fp)) !== FALSE) {


			// https://www.php.net/manual/en/control-structures.if.php
			// https://www.php.net/manual/en/language.operators.comparison.php

			if ($cells['3'] == '0') { // 排除 欄位 '3' 是 0 的 那一列(row)
				continue;
			}

			$data[] = $cells;
		}

		// https://www.php.net/manual/en/function.fclose.php
		fclose($fp);

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

		$target_data = load_csv_and_filter($input_csv); // 載入「var/input.csv」並且載入的過程，直接過濾。

		save_csv($output_csv, $target_data); // 將過濾後的資料「$target_data」，寫入「var/input.csv」。
	}


	main();
