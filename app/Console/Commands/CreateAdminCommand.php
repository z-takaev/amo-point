<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

final class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Создать аккаунт админа';

    public function handle(): int
    {
        $this->createOrUpdateAdmin();

        return self::SUCCESS;
    }

    private function createOrUpdateAdmin(): User
    {
        return User::query()->updateOrCreate(
            ['email' => config('dashboard.admin.email')],
            [
                'name' => config('dashboard.admin.name'),
                'password' => (string) config('dashboard.admin.password'),
            ],
        );
    }
}
