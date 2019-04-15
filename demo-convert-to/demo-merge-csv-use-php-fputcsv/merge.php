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


class AppMerge {
	protected $_Csv = array();

	public function run ()
	{
		$this->_Csv['source'] = (new FileCsvReader)
			->setFilePath(__DIR__ . '/1.csv')
			->load()
		;

		$source_data = $this->_Csv['source']->toArray();

		$this->_Csv['target'] = (new FileCsvReader)
			->setFilePath(__DIR__ . '/3.csv')
			->load()
		;

		$target_data = $this->_Csv['target']->toArray();


		//var_dump($source_data);
		//var_dump($target_data);

		foreach ($target_data as $target_row => $target_cols) {

			if ($target_row === 0) { // 不處理第一列
				continue;
			}

			foreach ($target_cols as $target_col => $target_cell) {

				if ($target_col >= 2) { // 不處理第三攔以後
					continue;
				}

				$source_cell = $source_data[$target_row][$target_col];

				$target_data[$target_row][$target_col] = $source_cell;
			}
		}

		$this->_Csv['final'] = (new FileCsvWriter)
			->setFilePath(__DIR__ . '/final.csv')
		;

		$this->_Csv['final']
			->setData($target_data)
			->save()
		;

		/*
		foreach ($this->_Csv as $csv) {
			$csv->close();
		}
		*/

	}

}


(new AppMerge)
	->run()
;
