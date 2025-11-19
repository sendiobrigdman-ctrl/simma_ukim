$target = Join-Path $PSScriptRoot '..\app\Models\User.php' | Resolve-Path -Relative
$content = @'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass-assignable attributes.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'jurusan',
        'angkatan',
        'ipk',
        'no_hp',
        'foto_path',
    ];

    /**
     * Hidden attributes for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'ipk' => 'float',
        'angkatan' => 'integer',
    ];

    /**
     * User has many aplikasi.
     */
    public function aplikasis()
    {
        return $this->hasMany(Aplikasi::class, 'user_id');
    }

    /**
     * If a user is a mitra, they have many lowongans.
     */
    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'mitra_id');
    }

    /**
     * Optional relation to Mitra model (company profile), if present.
     */
    public function mitraProfile()
    {
        return $this->hasOne(Mitra::class, 'user_id');
    }

    /**
     * Check role equality - used by views/middleware.
     */
    public function hasRole(string $role): bool
    {
        return isset($this->role) && $this->role === $role;
    }

}
'@

$enc = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllBytes((Resolve-Path $target).Path, $enc.GetBytes($content))
Write-Host "WROTE_NO_BOM"
