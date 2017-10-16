@echo off
for /F "tokens=*" %%A in (copydirs.txt) do (
    cd %%A
    for %%a in (*.tif*) do (
      if %%~a NEQ %0 (
        md "%%~na" 2>nul
        move "%%a" "%%~na\OBJ.tif"
      )	
    )
    for %%a in (*.xml*) do (
        move "%%a" "%%~na\MODS.xml"
      )
      cd ..\
)