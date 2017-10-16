# This should count the number of tiffs
# Then Copy a prepared 000.xml file

import os, fnmatch, shutil, itertools

path = os.getcwd()
dirs = sorted(os.listdir( path ))
thefile = open('copydirs.txt', 'w')
for dir in dirs:
    try:
        os.chdir(dir)
    except: pass
    finally: 
        currentDir = os.getcwd()
        print >> thefile, currentDir
        files = fnmatch.filter(os.listdir( currentDir ), "*.tif")
        fileCount = len(files)
        counter = 1
        for _ in range(fileCount-1):
            currentDirString= dir
            filePath = os.path.abspath(currentDir)
            metaFile = filePath + "\\" + "000.xml"
            newName = filePath + "\\" + str(counter).zfill(3) + ".xml"
            shutil.copy (metaFile, newName)
            counter += 1
            print newName + " created"
        os.chdir(path)