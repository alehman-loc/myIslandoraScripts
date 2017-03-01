@echo off
rem --METADATA--.xml , 
rem %%a-0001
for %%a in (*.xml*) do (
    move "%%a" "%%~na\POLICY.xml"
  )
