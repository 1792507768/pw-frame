@echo off
setlocal ENABLEDELAYEDEXPANSION
set currentDir=%~dp0
if "eclipse"=="%1" (
    rem ����IDE�ļ�
    for /R "%currentDir%tools\eclipse" %%s in (*) do (
        set s=%%s
        set fn=!s:\tools\eclipse\dot.=\.!
        if exist !fn! (
            echo exist - !fn!
        ) else (
            echo copy - !fn!
            echo F|xcopy "!s!" "!fn!">nul
        )
    )
    echo ok
) else (
    echo �ű��ο���
    echo    eclipse - ����IDE�ļ�
)