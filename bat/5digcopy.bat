@ECHO OFF
REM Verify src Folder , Original and destination copy filenames and count.
setlocal ENABLEDELAYEDEXPANSION
set src=X:\libdc_dick_scarlett\UniversityofWyomingBatch01\003_First_Drovers
set count=250

for /L %%f in (1,1,%count%) do (
	set j=000%%f
	copy %src%\003_First_Drovers-0001.xml %src%\003_First_Drovers-!j:~-4!.xml
)
ECHO ...%src% done...
endlocal

