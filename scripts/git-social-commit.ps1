param(
    [ValidateSet("random","prompt","message")]
    [string]$Mode = "random",
    [string]$Message = "",
    [switch]$NoPush
)

$messages = @(
    "login: inicio de sesión",
    "login: cierre de sesión",
    "social: actualización de perfil",
    "social: nuevo seguidor",
    "login: recuperación de contraseña",
    "social: publicación compartida",
    "login: sesión iniciada",
    "social: conexión creada"
)

if ($Mode -eq 'message' -and [string]::IsNullOrWhiteSpace($Message)) {
    Write-Error "Cuando -Mode=message debes proporcionar -Message 'texto'."
    exit 1
}

if ($Mode -eq 'prompt') {
    $Message = Read-Host 'Escribe el mensaje de commit (relacionado con login/red social)'
} elseif ($Mode -eq 'random') {
    $Message = Get-Random -InputObject $messages
}

Write-Output "Usando mensaje de commit: '$Message'"

Write-Output "Ejecutando: git pull origin main"
git pull origin main

$changes = git status --porcelain
if ($changes) {
    Write-Output "Cambios detectados: agregando y haciendo commit..."
    git add -A
    git commit -m "$Message"
} else {
    Write-Output "Sin cambios: creando commit vacío con mensaje temático..."
    git commit --allow-empty -m "$Message"
}

if (-not $NoPush) {
    Write-Output "Haciendo push a origin main..."
    git push origin main
} else {
    Write-Output "No se hará push (se indicó -NoPush)."
}

Write-Output "Último commit:"; git log -1 --pretty=format:"%h %an <%ae> %s"
