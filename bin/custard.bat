@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/rhubarbphp/custard/bin/custard
php "%BIN_TARGET%" %*
