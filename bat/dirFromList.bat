@echo off
REM Place this .bat file in folder with book folders
REM Update dirlist.txt to match the folders you want processed

setlocal ENABLEDELAYEDEXPANSION

for /F "tokens=*" %%A in (X:\libdc_dickScarlett_willisMcDonald_wyu_174227\Batch_03\dirlist.txt) do (
    cd ./%%A
    pwd
    for %%a in (*.tif*) do (
  if %%~a NEQ %0 (
    md "%%~na" 2>nul
    move "%%a" "%%~na\OBJ.tif"
  )	
)
for %%a in (*.jpg*) do (
    move "%%a" "%%~na\JPG.jpg"
  )
for %%a in (*.xml*) do (
    move "%%a" "%%~na\--METADATA--.xml"
  )
	for %%a in (*.txt*) do (
    move "%%a" "%%~na\OCR.txt"
  )
  cd ../
)
endlocal