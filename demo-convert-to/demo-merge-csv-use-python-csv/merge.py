#!/usr/bin/env python3


import csv

class FileCsv:

	_FilePath = None
	def getFilePath (self):
		return self._FilePath
	def setFilePath (self, val):
		self._FilePath = val
		return self

	_Data = []
	def getData (self):
		return self._Data
	def setData (self, val):
		self._Data = val
		return self

	def toArray (self):
		return self.getData()

class FileCsvReader(FileCsv):

	def load (self):
		with open(self.getFilePath()) as csv_file:
			cells = csv.reader(csv_file)

			self.setData([])

			for cell in cells:
				self.getData().append(cell)

		return self

class FileCsvWriter(FileCsv):

	def save (self):
		with open(self.getFilePath(), 'w') as csv_file:
			writer = csv.writer(csv_file)
			writer.writerows(self.getData())


class AppMerge:

	def run (self):

		source_csv = FileCsvReader().setFilePath('1.csv').load()
		target_csv = FileCsvReader().setFilePath('3.csv').load()

		source_data = source_csv.toArray()
		target_data = target_csv.toArray()


		for target_row, target_cols in enumerate(target_data): ## 從「列(row)」開始巡迴

			if target_row == 0: ## 不處理第一列
				continue


			for target_col, cell_target in enumerate(target_cols): ## 從「某列(row)」開始巡迴「欄(col)」

				if target_col >= 2: ## 不處理第三攔以後
					continue

				source_cell = source_data[target_row][target_col]
				target_data[target_row][target_col] = source_cell


		# print(target_data)

		final_csv = FileCsvWriter().setFilePath('final.csv').setData(target_data)

		final_csv.save() ## 把「target_data」寫到「final.csv」。

if __name__ == '__main__':
	AppMerge().run()
