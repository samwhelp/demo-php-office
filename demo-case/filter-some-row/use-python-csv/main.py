#!/usr/bin/env python3

# https://docs.python.org/3/library/csv.html
# https://docs.python.org/3/library/io.html
# https://blog.gtwang.org/programming/python-csv-file-reading-and-writing-tutorial/
# https://en.wikipedia.org/wiki/Fluent_interface#PHP

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


class AppFilter:

	def run (self):

		source_csv = FileCsvReader().setFilePath('var/input.csv').load()

		source_data = source_csv.toArray()

		target_data = []

		for source_row, source_cols in enumerate(source_data): ## 一列一列地巡迴

			#if source_row == 0: ## 不處理第一列
			#	continue


			#print(source_cols);

			if source_cols[3] == '0': ## 排除第四個欄位是「0」的那一列(row)。第四個欄位指的是「欄位D」。
				continue

			target_data.append(source_cols); ## 此列沒被排除，所以放到「target_data」。


		#print(target_data)

		target_csv = FileCsvWriter().setFilePath('var/output.csv').setData(target_data)

		target_csv.save() ## 把「target_data」寫到「var/output.csv」。

if __name__ == "__main__":
	AppFilter().run()
