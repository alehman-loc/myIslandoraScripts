# Copy xml files according to csv

import os, fnmatch, shutil, itertools
path = os.getcwd()
currentDir = os.path.abspath ( path ) + str("\")

print currentDir