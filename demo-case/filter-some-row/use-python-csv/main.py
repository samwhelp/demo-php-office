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


class AppFilter:

	def run (self):

		csv_source = FileCsvReader().setFilePath('var/input.csv').load()

		data_source = csv_source.toArray()

		data_target = []

		for row_source, cells_source in enumerate(data_source):

			#if row_source == 0: # 不處理第一列
			#	continue


			#print(cells_source);

			if cells_source[3] == '0':
				continue

			data_target.append(cells_source);


		#print(data_target)

		csv_target = FileCsvWriter().setFilePath('var/output.csv').setData(data_target)

		csv_target.save()

if __name__ == "__main__":
	AppFilter().run()
