@echo off
setlocal ENABLEDELAYEDEXPANSION

for /F "tokens=*" %%A in (copydirs.txt) do (
    ECHO processing %%A....
    for /L %%f in (1,1,3) do (
        set j=00%%f
        copy X:\Bookeye_Exports\Wyoming_Student\v_19_1916_1917\%%A\000.xml X:\Bookeye_Exports\Wyoming_Student\v_19_1916_1917\%%A\!j:~-3!.xml
    )
)
endlocal
