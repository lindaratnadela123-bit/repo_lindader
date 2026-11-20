param(
    [string]$DatabaseName = 'db_workshop',
    [string]$DatabaseUser = 'root',
    [string]$OutputDirectory = $PSScriptRoot,
    [switch]$PromptForPassword
)

$ErrorActionPreference = 'Stop'

if ($DatabaseName -notmatch '^[A-Za-z0-9_]+$') {
    throw 'DatabaseName may contain only letters, numbers, and underscores.'
}

$dumpCommand = Get-Command mysqldump -ErrorAction SilentlyContinue
if ($dumpCommand) {
    $dumpPath = $dumpCommand.Source
} else {
    $dumpPath = Get-ChildItem 'C:\laragon\bin\mysql' -Directory -ErrorAction SilentlyContinue |
        ForEach-Object { Join-Path $_.FullName 'bin\mysqldump.exe' } |
        Where-Object { Test-Path $_ } |
        Select-Object -First 1
}
if (-not $dumpPath) {
    throw 'mysqldump.exe was not found. Add it to PATH or install MySQL in Laragon.'
}

if (-not (Test-Path $OutputDirectory)) {
    New-Item -ItemType Directory -Path $OutputDirectory -Force | Out-Null
}

$timestamp = Get-Date -Format 'yyyyMMdd_HHmmss'
$outputPath = Join-Path $OutputDirectory "${DatabaseName}_${timestamp}.sql"
$temporaryPath = Join-Path $OutputDirectory "${DatabaseName}_${timestamp}.sql.tmp"
$arguments = @('--host=localhost', "--user=$DatabaseUser", '--single-transaction', '--routines', '--triggers')
if ($PromptForPassword) {
    $arguments += '--password'
}
$arguments += $DatabaseName

& $dumpPath @arguments > $temporaryPath
if ($LASTEXITCODE -ne 0 -or -not (Test-Path $temporaryPath) -or (Get-Item $temporaryPath).Length -eq 0) {
    if (Test-Path $temporaryPath) {
        Remove-Item -LiteralPath $temporaryPath -Force
    }
    throw "Database backup failed for $DatabaseName."
}

Move-Item -LiteralPath $temporaryPath -Destination $outputPath
$logPath = Join-Path $OutputDirectory 'LOG_BACKUP.md'
Add-Content -LiteralPath $logPath -Value "| $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss') | $([IO.Path]::GetFileName($outputPath)) | $DatabaseName | Belum diuji |"
Write-Output "Backup berhasil: $outputPath"
