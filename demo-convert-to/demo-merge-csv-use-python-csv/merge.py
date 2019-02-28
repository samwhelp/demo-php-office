#!/usr/bin/env python3


import csv

class FileCsv:

	_FilePath = None
	def getFilePath (self):
		return self._FilePath
	def setFilePath (self, val):
		self._FilePath = val
		return self

	_Handle = None
	def getHandle (self):
		return self._Handle
	def setHandle (self, val):
		self._Handle = val
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

		csv_source = FileCsvReader().setFilePath('1.csv').load()

		csv_target = FileCsvReader().setFilePath('3.csv').load()

		data_source = csv_source.toArray()
		data_target = csv_target.toArray()


		for row_target, cells_target in enumerate(csv_target.toArray()):

			if row_target == 0: # 不處理第一列
				continue


			for col_target, cell_target in enumerate(cells_target):

				if col_target >= 2: # 不處理第三攔以後
					continue

				cell_source = data_source[row_target][col_target]
				data_target[row_target][col_target] = cell_source


		# print(data_target)

		csv_final = FileCsvWriter().setFilePath('final.csv').setData(data_target)

		csv_final.save()

if __name__ == "__main__":
	AppMerge().run()
