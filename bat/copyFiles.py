# This should count the number of tiffs
# Then Copy a prepared -0001.xml file

import os, fnmatch, shutil, itertools

path = os.getcwd()
dirs = sorted(os.listdir( path ))

for dir in dirs:
    os.chdir(dir)
    currentDir = os.getcwd()
    files = fnmatch.filter(os.listdir( currentDir ), "*.tif")
    fileCount = len(files)
    counter = 2
    for _ in range(fileCount-1):
        currentDirString= dir
        filePath = os.path.abspath(currentDir)
        metaFile = filePath + "\\" + dir + "-0001.xml"
        newName = filePath + "\\" + dir + "-" + str(counter).zfill(4) + ".xml"
        shutil.copy (metaFile, newName)
        counter += 1
    #print Confirmation!!
    os.chdir(path)