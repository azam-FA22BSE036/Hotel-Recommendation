param(
    [switch]$NoBuild
)

Write-Host "Starting Laravel project setup..." -ForegroundColor Cyan

$ErrorActionPreference = 'Stop'

function Ensure-Path([string]$PathToAdd) {
    if (-not [string]::IsNullOrWhiteSpace($PathToAdd)) {
        if (-not ($env:Path -split ';' | Where-Object { $_ -eq $PathToAdd })) {
            $env:Path = "$PathToAdd;$env:Path"
        }
    }
}

function Exec([string]$Command, [string]$ErrorMessage) {
    Write-Host "> $Command" -ForegroundColor DarkGray
    $psi = New-Object System.Diagnostics.ProcessStartInfo
    $psi.FileName = 'powershell.exe'
    $psi.Arguments = "-NoProfile -ExecutionPolicy Bypass -Command `$ErrorActionPreference='Stop'; $Command"
    $psi.UseShellExecute = $false
    $psi.RedirectStandardOutput = $true
    $psi.RedirectStandardError = $true
    $p = [System.Diagnostics.Process]::Start($psi)
    $out = $p.StandardOutput.ReadToEnd()
    $err = $p.StandardError.ReadToEnd()
    $p.WaitForExit()
    if ($p.ExitCode -ne 0) {
        if ($out) { Write-Host $out }
        if ($err) { Write-Host $err -ForegroundColor Red }
        throw $ErrorMessage
    }
    if ($out) { Write-Host $out }
}

# 1) Ensure Scoop
try {
    if (-not (Get-Command scoop -ErrorAction SilentlyContinue)) {
        Write-Host "Installing Scoop..." -ForegroundColor Yellow
        iwr -useb get.scoop.sh | iex
        $scoopShims = Join-Path $env:USERPROFILE 'scoop\shims'
        Ensure-Path $scoopShims
    }
} catch {
    Write-Host "Scoop install step failed: $($_.Exception.Message)" -ForegroundColor Red
    throw
}

# 2) Use Scoop to install PHP and Composer
try {
    Write-Host "Ensuring 'main' bucket and installing php + composer..." -ForegroundColor Yellow
    scoop bucket add main | Out-Null
    scoop install php composer | Out-Null
} catch {
    Write-Host "Scoop install php/composer failed: $($_.Exception.Message)" -ForegroundColor Red
    throw
}

# 3) Verify PHP/Composer
try {
    php -v
    composer -V
} catch {
    Write-Host "PHP/Composer not available after installation: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Close and reopen a new PowerShell window, then rerun this script." -ForegroundColor Yellow
    throw
}

# 4) Prepare Laravel env (already set to SQLite by previous edit, but ensure file exists)
try {
    if (-not (Test-Path -Path 'database')) {
        New-Item -ItemType Directory -Force -Path 'database' | Out-Null
    }
    if (-not (Test-Path -Path 'database\database.sqlite')) {
        New-Item -ItemType File -Force -Path 'database\database.sqlite' | Out-Null
    }
} catch {
    Write-Host "Creating SQLite file failed: $($_.Exception.Message)" -ForegroundColor Red
    throw
}

# 5) Backend deps
try {
    if (-not (Test-Path -Path 'vendor')) {
        Exec 'composer install --no-interaction --prefer-dist' 'Composer install failed'
    }
    Exec 'php artisan key:generate' 'Key generate failed'
    Exec 'php artisan migrate --seed' 'Migrate/seed failed'
} catch {
    Write-Host "Backend setup failed: $($_.Exception.Message)" -ForegroundColor Red
    throw
}

# 6) Frontend build (optional)
try {
    if (-not $NoBuild) {
        if (Get-Command npm -ErrorAction SilentlyContinue) {
            if (-not (Test-Path -Path 'node_modules')) {
                cmd /c npm install
            }
            cmd /c npm run build
        } else {
            Write-Host "npm not found; skipping asset build (already built assets may exist)." -ForegroundColor Yellow
        }
    }
} catch {
    Write-Host "Frontend build failed: $($_.Exception.Message)" -ForegroundColor Yellow
}

# 7) Serve
Write-Host "Starting Laravel dev server at http://localhost:8888" -ForegroundColor Green
php artisan serve --host=localhost --port=8888



