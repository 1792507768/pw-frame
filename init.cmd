@echo off
setlocal ENABLEDELAYEDEXPANSION
set currentDir=%~dp0
if "eclipse"=="%1" (
    rem 拷贝IDE文件
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
    echo 脚本参考：
    echo    eclipse - 拷贝IDE文件
)