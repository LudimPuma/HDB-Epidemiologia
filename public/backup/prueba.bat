@echo off
echo COPIA BASE DE DATOS
color a
SET PG_BIN="C:\Program Files\PostgreSQL\9.3\bin\pg_dump.exe"
SET PG_HOST=localhost
SET PG_PORT=5432
SET PG_DATABASE=HDB-Epidemiologia
SET PG_USER=postgres
SET PGPASSWORD=sistemas

REM Obtener fecha y hora actual en formato específico
for /f "delims=" %%a in ('powershell -Command Get-Date -Format "yyyy-MM-dd_HH-mm-ss"') do set "FECHAYHORA=%%a"

SET PG_FILENAME="C:\xampp\htdocs\HDB-Epi\storage\app\public\backups\backup_%PG_DATABASE%_%FECHAYHORA%.backup"
%PG_BIN% -h %PG_HOST% -p %PG_PORT% -U %PG_USER% --format custom -b -f %PG_FILENAME% %PG_DATABASE%
