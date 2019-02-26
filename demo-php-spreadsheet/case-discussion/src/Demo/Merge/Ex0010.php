<?php

namespace Demo\Merge;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class Ex0010 {

	public function run ()
	{
		//var_dump(__METHOD__);

		$this->prepareDir();




////////////////////////////////////////////////////////////////////////////////
//
		// 載入「asset/merge/merge/1.ods」
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php
		$file_path_1 = THE_ASSET_DIR_PATH . '/merge/1.ods';

		$spreadsheet_1 = IOFactory::load($file_path_1);

		$data_1 = $spreadsheet_1->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_1);
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 載入「asset/merge/merge/3.ods」
		// https://github.com/PHPOffice/PhpSpreadsheet/blob/master/samples/Reader/01_Simple_file_reader_using_IOFactory.php
		$file_path_3 =  THE_ASSET_DIR_PATH . '/merge/3.ods';

		$spreadsheet_3 = IOFactory::load($file_path_3);

		//var_dump($spreadsheet_3->getActiveSheet()->getCell('C3')->getValue());

		$data_3 = $spreadsheet_3->getActiveSheet()->toArray(null, true, true, true);
		//var_dump($data_3);
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//

		/*
			1.Ods

			A, B

		1	x, y
		2	1, 2
		3	3, 4

		*/


		/*
			3.Ods

			A, B, C

		1	x, y, sum
		2	 ,  , =SUM(A2:B2)
		3	 ,  , =SUM(A3:B3)

		*/

		/*
			原本「3.ods」的「C2」是「=SUM(A2:B2)」
			原本「3.ods」的「C3」是「=SUM(A3:B3)」
			這個範例會將「1.ods」的「A2」「A3」「B2」「B2」的值,
			填到「3.ods」的「A2」「A3」「B2」「B2」，
			然後另存到「var/merge-ex0010/final.ods」這個檔案。
		*/

		foreach ( $data_3 as $row_index_3 => $row_3) {
			if ($row_index_3 == 1) {
				continue;
			}

			foreach ($row_3 as $col_index_3 => $col_3) {

				if ($col_index_3 == 'C') {
					continue;
				}
				$cell_name = $col_index_3 . $row_index_3;

				//var_dump($col_index_3 . $row_index_3  );
				//$new_val = '1';
				$new_val = $data_1[$row_index_3][$col_index_3];
				$spreadsheet_3->getActiveSheet()->setCellValue($cell_name, $new_val);

			}
		}
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 這裡要將「Cache」清除，這樣最後寫入的時候，「C2」和「C3」才會是正確的值。
		// https://phpspreadsheet.readthedocs.io/en/latest/topics/calculation-engine/#calculation-cache
		//Calculation::getInstance($spreadsheet_3)->disableCalculationCache();
		Calculation::getInstance($spreadsheet_3)->clearCalculationCache();
//
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
//
		// 另存新檔到「var/merge-ex0010/final.ods」。
		$file_path_final = THE_VAR_DIR_PATH . '/merge-ex0010/final.ods';
		$writer = IOFactory::createWriter($spreadsheet_3, "Ods");
		$writer->save($file_path_final);
//
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//
		// 完成後，顯示提示訊息
		echo 'Merge_file_1: ' . $file_path_1;
		echo PHP_EOL;
		echo 'Merge_file_3: ' . $file_path_3;
		echo PHP_EOL;
		echo 'Merge_final: ' . $file_path_final;
		echo PHP_EOL;
		echo 'Open_final, Please run: ';
		echo PHP_EOL;
		echo '$ localc '. $file_path_final;
		echo PHP_EOL;
//
////////////////////////////////////////////////////////////////////////////////

	}

	protected function prepareDir ()
	{
		$dir_path = THE_VAR_DIR_PATH . '/merge-ex0010';

		if (file_exists($dir_path)) {
			return;
		}

		mkdir($dir_path, 0755 ,true);
	}

} // End class Hello
