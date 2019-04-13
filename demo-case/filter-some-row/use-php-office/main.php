#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Model {

	// https://en.wikipedia.org/wiki/Fluent_interface#PHP

	protected $_SourceFilePath = '';
	public function setSourceFilePath($val) {
		$this->_SourceFilePath = $val;
		return $this;
	}


	protected $_TargetFilePath = '';
	public function setTargetFilePath($val) {
		$this->_TargetFilePath = $val;
		return $this;
	}

	protected $_SourceSpreadsheet = NULL;


	public function run ()
	{
		//var_dump(__METHOD__);

		$this->filter();
	}


	protected function filter ()
	{
		//var_dump(__METHOD__);
		//var_dump($this->_SourceFilePath);
		//var_dump($this->_TargetFilePath);

		// ## 檢查來源檔案是否存在
		if (!file_exists($this->_SourceFilePath)) {
			echo 'File-Not-Exists: ' . $this->_SourceFilePath;
			echo PHP_EOL;
			return;
		}


		// ## 載入來源檔案
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_load
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html
		$this->_SourceSpreadsheet = IOFactory::load($this->_SourceFilePath);

		// ## 獲得來源資料
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Spreadsheet.html#method_getActiveSheet
		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_toArray
		$source = $this->_SourceSpreadsheet->getActiveSheet()->toArray(null, true, true, true);

		$target = []; // 這個使用來儲存挑出來的那些列，只是為了除錯用。

		// ## 從第一列(row) 開始跑到 最後一列
		$deleted_rows = 0; // 已經刪除的列數。
		foreach ($source as $index => $cells) {
			//var_dump($cells);

			// https://www.php.net/manual/en/control-structures.if.php
			// https://www.php.net/manual/en/language.operators.comparison.php

			if ($cells['D'] != '0') { // 挑出 欄位 'D' 不是 0 的 那一列
				$target[] = $cells; // 儲存挑出來的這列，只是除錯用
				continue;
			}
			//var_dump($deleted_rows);

			//https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_removeRow
			$this->_SourceSpreadsheet->getActiveSheet()->removeRow($index-$deleted_rows);

			$deleted_rows++;


		}

		//var_dump($target); // 秀出挑出來的那些列。


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_createWriter
		$writer = IOFactory::createWriter($this->_SourceSpreadsheet, 'Ods');

		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Writer/IWriter.html#method_save
		$writer->save($this->_TargetFilePath);

	}

} // class Model

class App {

	public function showUsage()
	{
		echo './main.php input.ods output.ods';
		echo PHP_EOL;
	}

	public function run ()
	{
		// https://www.php.net/manual/en/reserved.variables.argc.php
		// https://www.php.net/manual/en/reserved.variables.argv.php
		$argc = $_SERVER['argc'];
		$argv = $_SERVER['argv'];

		//var_dump($argc);
		//var_dump($argv);


		// 範例指令下法
		// $ ./main.php input.ods output.ods
		// $ ./main.php 'data/input.ods' 'var/output.ods'
		// ## 檢查指令參數
		if ($argc < 3) { // 指令參數必須要有「input.ods」和「output.ods」，沒有就要秀使用訊息。
			$this->showUsage();
			return;
		}

		// ## 執行過濾流程，並且另存新檔
		(new Model)
			->setSourceFilePath($argv[1]) // 舉例：將第一個指令參數「input.ods」，設為「來源檔案位置」。
			->setTargetFilePath($argv[2]) // 舉例：將第二個指令參數「output.ods」，設為「另存新檔位置」。
			->run()
		;
	}

}

(new App)->run();


// $ ./main.php data/input.ods var/output.ods


/*
https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_removeRow
*/
