Param(
    [string]$ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path,
    [string]$OutputRoot = "deploy\hostinger-package",
    [string]$ZipName = "sistem-antrian-hostinger.zip",
    [switch]$NoZip
)

$ErrorActionPreference = "Stop"

function Write-Step {
    Param([string]$Message)
    Write-Host "[HOSTINGER-PACK] $Message" -ForegroundColor Cyan
}

$fullOutputRoot = Join-Path $ProjectRoot $OutputRoot
$zipPath = Join-Path $ProjectRoot (Join-Path "deploy" $ZipName)
$laravelAppPath = Join-Path $fullOutputRoot "laravel-app"
$publicHtmlPath = Join-Path $fullOutputRoot "public_html"

Write-Step "Project root: $ProjectRoot"
Write-Step "Preparing output folder..."
if (Test-Path $fullOutputRoot) {
    Remove-Item -Path $fullOutputRoot -Recurse -Force
}
New-Item -Path $laravelAppPath -ItemType Directory -Force | Out-Null
New-Item -Path $publicHtmlPath -ItemType Directory -Force | Out-Null

Write-Step "Copying Laravel app files..."
$excludedDirs = @(
    ".git",
    ".github",
    ".vscode",
    "node_modules",
    "deploy",
    "storage\logs"
)
$excludedFiles = @(
    ".env",
    "*.log"
)

$robocopyArgsApp = @(
    "`"$ProjectRoot`"",
    "`"$laravelAppPath`"",
    "/E",
    "/R:1",
    "/W:1",
    "/NFL",
    "/NDL",
    "/NJH",
    "/NJS",
    "/NC",
    "/NS",
    "/NP"
)
if ($excludedDirs.Count -gt 0) {
    $robocopyArgsApp += "/XD"
    $robocopyArgsApp += $excludedDirs
}
if ($excludedFiles.Count -gt 0) {
    $robocopyArgsApp += "/XF"
    $robocopyArgsApp += $excludedFiles
}

& robocopy @robocopyArgsApp | Out-Null

Write-Step "Copying public folder to public_html..."
$robocopyArgsPublic = @(
    "`"$(Join-Path $ProjectRoot 'public')`"",
    "`"$publicHtmlPath`"",
    "*.*",
    "/E",
    "/R:1",
    "/W:1",
    "/NFL",
    "/NDL",
    "/NJH",
    "/NJS",
    "/NC",
    "/NS",
    "/NP"
)
& robocopy @robocopyArgsPublic | Out-Null

Write-Step "Adjusting public_html/index.php path for Hostinger structure..."
$indexPath = Join-Path $publicHtmlPath "index.php"
$indexContent = Get-Content -Path $indexPath -Raw
$indexContent = $indexContent -replace "__DIR__\.'/\.\./storage", "__DIR__.'/../laravel-app/storage"
$indexContent = $indexContent -replace "__DIR__\.'/\.\./vendor/autoload.php'", "__DIR__.'/../laravel-app/vendor/autoload.php'"
$indexContent = $indexContent -replace "__DIR__\.'/\.\./bootstrap/app.php'", "__DIR__.'/../laravel-app/bootstrap/app.php'"
Set-Content -Path $indexPath -Value $indexContent -Encoding UTF8

Write-Step "Copying Hostinger env template..."
Copy-Item -Path (Join-Path $ProjectRoot ".env.hostinger.example") -Destination (Join-Path $laravelAppPath ".env") -Force

Write-Step "Creating upload notes inside package..."
$notes = @"
1. Upload folder laravel-app and public_html to the same parent directory in Hostinger File Manager.
2. Set your domain document root to public_html (default in Hostinger).
3. Edit laravel-app/.env with production database and app URL.
4. Run in Hostinger terminal (inside laravel-app):
   php artisan key:generate --force
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
5. Ensure laravel-app/storage and laravel-app/bootstrap/cache are writable.
"@
Set-Content -Path (Join-Path $fullOutputRoot "README-UPLOAD.txt") -Value $notes -Encoding UTF8

if ($NoZip) {
    Write-Step "NoZip enabled. Package folder is ready at: $fullOutputRoot"
} else {
    Write-Step "Creating zip package..."
    $zipDir = Split-Path $zipPath -Parent
    if (-not (Test-Path $zipDir)) {
        New-Item -Path $zipDir -ItemType Directory -Force | Out-Null
    }
    if (Test-Path $zipPath) {
        Remove-Item -Path $zipPath -Force
    }
    Compress-Archive -Path (Join-Path $fullOutputRoot "*") -DestinationPath $zipPath -Force
    Write-Step "Done. Package created at: $zipPath"
}
