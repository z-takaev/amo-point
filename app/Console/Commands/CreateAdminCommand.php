<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

final class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Создать аккаунт для входа в dashboard';

    public function handle(): int
    {
        $user = $this->createOrUpdateAdmin();

        $this->components->info(sprintf(
            'Аккаунт готов: %s (%s)',
            $user->name,
            $user->email,
        ));

        return self::SUCCESS;
    }

    private function createOrUpdateAdmin(): User
    {
        return User::query()->updateOrCreate(
            ['email' => config('dashboard.admin.email')],
            [
                'name' => config('dashboard.admin.name'),
                'password' => Hash::make((string) config('dashboard.admin.password')),
            ],
        );
    }
}
