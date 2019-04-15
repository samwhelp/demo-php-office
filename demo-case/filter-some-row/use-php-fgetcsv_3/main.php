#!/usr/bin/env php
<?php


abstract class FileCsv {
	protected $_FilePath = NULL;
	public function getFilePath ()
	{
		return $this->_FilePath;
	}
	public function setFilePath ($val)
	{
		$this->_FilePath = $val;
		return $this;
	}

	protected $_Handle = NULL;
	public function getHandle ()
	{
		return $this->_Handle;
	}
	public function setHandle ($val)
	{
		$this->_Handle = $val;
		return $this;
	}

	protected $_Data = array();
	public function getData ()
	{
		return $this->_Data;
	}
	public function setData ($val)
	{
		$this->_Data = $val;
		return $this;
	}

	public function toArray ()
	{
		return $this->getData();
	}

	public function open ()
	{
		return $this;
	}

	public function close ()
	{
		$handle = $this->getHandle();

		if ($handle === NULL) {
			return;
		}
		fclose($handle);

		$this->setHandle(NULL);

		return $this;
	}



}

class FileCsvReader extends FileCsv {

	public function open ()
	{
		if (($this->_Handle = fopen($this->getFilePath(), 'r')) === FALSE) {
			return;
		}

		return $this;
	}

	public function load ($length=0, $delimiter=',', $enclosure='"', $escape="\\")
	{
		$this->open();

		while (($cols = $this->readRow()) !== FALSE) {
			array_push($this->_Data, $cols);
		}

		$this->close();

		return $this;
	}

	public function readRow ($length=0, $delimiter=',', $enclosure='"', $escape="\\")
	{
		// http://php.net/manual/en/function.fgetcsv.php
		return fgetcsv($this->getHandle(), $length, $delimiter, $enclosure, $escape);
	}


}

class FileCsvWriter extends FileCsv {

	public function open ()
	{
		if (($this->_Handle = fopen($this->getFilePath(), 'w')) === FALSE) {
			return;
		}

		return $this;
	}

	public function save ($delimiter=',', $enclosure='"', $escape="\\")
	{
		$this->open();

		foreach ($this->getData() as $cells) {
			$this->writeRow($cells, $delimiter, $enclosure, $escape);
		}

		$this->close();

		return $this;
	}

	public function writeRow ($cells=array(), $delimiter=',', $enclosure='"', $escape="\\")
	{
		// http://php.net/manual/en/function.fputcsv.php
		return fputcsv($this->getHandle(), $cells, $delimiter=',', $enclosure='"', $escape="\\");
	}

}


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


		$target_csv = (new FileCsvWriter)
			->setFilePath($this->_TargetFilePath)
			->open()
		;


		$source_csv = (new FileCsvReader)
			->setFilePath($this->_SourceFilePath)
			->open()
		;


		while (($source_cols = $source_csv->readRow()) !== FALSE) {
			/*
			if ($source_row === 0) { // 不處理第一列
				continue;
			}
			*/

			// https://www.php.net/manual/en/control-structures.if.php
			// https://www.php.net/manual/en/language.operators.comparison.php

			if ($source_cols['3'] == '0') { // 排除「欄位 3 (D)」是「0」的 那一列(row)
				continue;
			}

			$target_csv->writeRow($source_cols);
		}


		$source_csv->close();
		$target_csv->close();

	}

} // End class Model

class App {

	public function showUsage()
	{
		echo './main.php input.csv output.csv';
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

} // End class App

(new App)->run();
