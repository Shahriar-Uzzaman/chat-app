<?php

namespace App\Providers;

use App\Repositories\Contracts\AuthenticationRepositoryInterface;
use App\Repositories\Contracts\Location\CountryRepositoryInterface;
use App\Repositories\Contracts\Location\StateRepositoryInterface;
use App\Repositories\Contracts\OtpRepositoryInterface;
use App\Repositories\Contracts\User\About\EducationRepositoryInterface;
use App\Repositories\Contracts\User\About\ProfileRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AuthenticationRepository;
use App\Repositories\Eloquent\Location\CountryRepository;
use App\Repositories\Eloquent\Location\StateRepository;
use App\Repositories\Eloquent\OtpRepository;
use App\Repositories\Eloquent\User\About\EducationRepository;
use App\Repositories\Eloquent\User\About\ProfileRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OtpRepositoryInterface::class, OtpRepository::class);
        $this->app->bind(AuthenticationRepositoryInterface::class, AuthenticationRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(EducationRepositoryInterface::class, EducationRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
