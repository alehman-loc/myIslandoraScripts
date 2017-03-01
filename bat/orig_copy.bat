@ECHO OFF
setlocal ENABLEDELAYEDEXPANSION
set src=Y:\libdc_BrandingIron_wyu_169935\Uploading\v_79_no_6_Oct_21_1971_ingest
set count=23

for /L %%f in (1,1,%count%) do (
	set j=00%%f
	copy %src%\000.xml %src%\!j:~-3!.xml
)
endlocal

