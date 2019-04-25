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

		$this->initView();

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

		$sheet = $this->_SourceSpreadsheet->getActiveSheet(); //目前使用的sheet，因為只有一個，所以呼叫這個就可以了
		$source = $sheet->toArray(null, true, true, true); //將sheet的資料，轉成php的array來操作。


		// ## 從第一列(row) 開始跑到 最後一列
		foreach ($source as $index => $cols) {
			//var_dump($cols);

			// https://www.php.net/manual/en/control-structures.if.php
			// https://www.php.net/manual/en/language.operators.comparison.php

			$title = '';
			if (array_key_exists('A', $cols)) { //檢查欄位「A」是否有資料。
				$title = trim($cols['A']);
			}

			if (!$title) { // 第一欄(欄位A)若是空白，略過
				continue;
			}

			//var_dump($title);

			// ## 拆解「欄位A」的資料，
			// https://www.php.net/manual/en/function.explode.php
			$temp = explode(' ', $title, 2); // 以「空白」為基準，來拆解。
			$main = $temp[0]; //拆解後的第一個值
			$sub = $temp[1]; //拆解後的第二個值

			// ## 做選取的動作，這是您原本要的主要功能。
			$this->selectTitle($main, $title);


		}


		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/IOFactory.html#method_createWriter
		$writer = IOFactory::createWriter($this->_SourceSpreadsheet, 'Ods');

		// https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Writer/IWriter.html#method_save
		$writer->save($this->_TargetFilePath); //另存新檔到「var/output.ods」。

	}

	protected function selectTitle($key, $val)
	{

		// 根據「$key」來篩選，若沒有存在「$this->_View」裡，就不處理。
		// 關於「$key」有可能的執行，請參考下面的「initView」，
		// 目前設定的有「SK040」，「EKONOR」，「KC045」
		if (!array_key_exists($key, $this->_View)) {
			return;
		}

		$sheet = $this->_SourceSpreadsheet->getActiveSheet();

		$this->storeTitle($key, $val); // 選中，將第一欄的資料，存到「$this->_View」;
		$cell = $this->findPutCellName($key); // 根據「$this->_View」的定義，找出，放到那個「call」，這裡的「$cell」指的是「cell_name」，例如: 「D1」，「D2」，「E1」，「E2」。

		//https://phpoffice.github.io/PhpSpreadsheet/master/PhpOffice/PhpSpreadsheet/Worksheet/Worksheet.html#method_setCellValue
		$sheet->setCellValue($cell, $val); // 將剛剛選中的值，存到新的欄位去。
		//$sheet->setCellValue('D1', 'SK040 004-10'); //上面的動作，類似這一行，這裡舉例，幫助您理解這個動作。

	}

	protected function findPutCellName($key)
	{
		//請參考下面「$this->_View」的定義。
		// https://www.php.net/manual/es/function.count.php
		$row_put = count($this->_View[$key]['Selected']); // 舉例: 若「$key」的值是「SK040」，則「$row_put」的值，就要根據之前選中的，來判斷下一個會存在那一行，這裡的「$row_put」，有可能的值「1」,「2」，「3」....

		$col_put = $this->_View[$key]['PutColumn']; // 舉例: 若「$key」的值是「SK040」，則「$col_put」的值，就是「D」

		return $col_put . $row_put; // 這裡得到的值，舉例: 「D1」，「D2」，「E1」，「E2」。
	}

	protected function storeTitle($key, $val)
	{
		//請參考下面「$this->_View」的定義。
		$this->_View[$key]['Selected'][] = $val; //將選中的，暫存到「$this->_View」，這個可以輔助用來判斷上面的「$row_put」。
	}

	protected $_View = [];
	protected function initView()
	{
		$view = []; //暫存在「$view」;

		$item = [];
		$item['PutColumn'] = 'D';
		$item['Selected'] = [];
		$view['SK040'] = $item;


		$item = [];
		$item['PutColumn'] = 'E';
		$item['Selected'] = [];
		$view['EKONOR'] = $item;


		$item = [];
		$item['PutColumn'] = 'F';
		$item['Selected'] = [];
		$view['KC045'] = $item;


		$item = [];
		$item['PutColumn'] = 'G';
		$item['Selected'] = [];
		$view['ENB045'] = $item;

		//var_dump($view);

		$this->_View = $view; //將上面的「$view」，複製到「$this->_View」。
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
