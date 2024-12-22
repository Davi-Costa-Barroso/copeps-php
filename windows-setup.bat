@echo off
setlocal enabledelayedexpansion

:: Solicita privilégios de Administrador
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo Solicitando privilegios de Administrador...
    powershell -Command "Start-Process cmd.exe -ArgumentList '/c %~s0' -Verb RunAs"
    exit /b
)

:: Variáveis
set "Installer=LibreOffice_24.8.4_Win_x86-64.msi"
set "URL=https://download.documentfoundation.org/libreoffice/stable/24.8.4/win/x86_64/LibreOffice_24.8.4_Win_x86-64.msi"
set "LibreOfficePath=C:\Program Files\LibreOffice\program"

:: Verifica se LibreOffice já está instalado
if exist "%LibreOfficePath%\soffice.exe" (
    echo LibreOffice ja esta instalado!
    goto ValidarPATH
)

:: Baixa o instalador usando CURL
if not exist "%~dp0%Installer%" (
    echo Baixando o instalador do LibreOffice...
    curl -L -o "%~dp0%Installer%" "%URL%"
    if %errorlevel% neq 0 (
        echo Erro: O download do instalador falhou.
        exit /b 1
    )
)

:: Instala o LibreOffice
echo Instalando o LibreOffice...
start /wait msiexec.exe /i "%~dp0%Installer%" /qn /norestart
if %errorlevel% neq 0 (
    echo Erro: A instalacao falhou com o código de erro %errorlevel%.
    exit /b %errorlevel%
)
echo Instalacao concluida com sucesso!

:: Adiciona LibreOffice ao PATH do sistema corretamente
echo Adicionando LibreOffice ao PATH do sistema...
for /f "tokens=2*" %%A in ('reg query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v PATH') do set CurrentPath=%%B

echo Caminho atual: !CurrentPath!
echo !CurrentPath! | findstr /i "LibreOffice" >nul
if %errorlevel% neq 0 (
    reg add "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v PATH /t REG_EXPAND_SZ /d "!CurrentPath!;%LibreOfficePath%" /f
    echo LibreOffice foi adicionado ao PATH com sucesso!
) else (
    echo LibreOffice ja esta no PATH.
)

:: Validação do PATH
:ValidarPATH
echo Verificando configuracao do PATH...
where soffice >nul 2>&1
if %errorlevel% neq 0 (
    echo Erro: O LibreOffice nao foi encontrado no PATH.
    exit /b 1
)
echo Validacao do PATH concluida com sucesso!

:: Remove o instalador
if exist "%~dp0%Installer%" (
    echo Removendo o instalador...
    del /f /q "%~dp0%Installer%"
)

echo Todas as etapas foram concluidas com sucesso!
pause
endlocal
