<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'user_role_id',
        'employee_id',
        'password',
    ];

    /**
     * @var array<int, string>|null
     */
    private ?array $permissionSlugs = null;

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class);
    }

    public function hasPermission(string $slug): bool
    {
        return in_array($slug, $this->permissionSlugs(), true);
    }

    /**
     * Slugs liberados pelo cargo do usuário, carregados uma única vez por instância.
     * Usuário sem cargo, ou com cargo inativo, não tem permissão alguma.
     *
     * @return array<int, string>
     */
    private function permissionSlugs(): array
    {
        if ($this->permissionSlugs !== null) {
            return $this->permissionSlugs;
        }

        $role = $this->userRole;

        if ($role === null || strcasecmp($role->status, 'ativo') !== 0) {
            return $this->permissionSlugs = [];
        }

        return $this->permissionSlugs = $role->rolePermissions()->pluck('slug')->all();
    }
}
