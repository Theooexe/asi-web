<?php

use App\Models\User;
use App\Services\AuthenticationService;
use Carbon\Carbon;


test('createToken adds a 20 characters token to the user', function () {
    // 1. Préparation
    $user = User::query()->create([
        'name'     => 'Test User',
        'email'    => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $service = new AuthenticationService($user);

    // 2. Action
    $service->createToken();

    // 3. Assertion (Expectation API)
    expect($user->token)->not->toBeNull()
        ->and(strlen($user->token))->toBe(20);
});

/**
 * BUT : Tester la méthode checkToken
 */
describe('checkToken method', function () {

    test('returns false if the token validity exceeds 24h', function () {
        $user = User::query()->create([
            'name'             => 'Expired User',
            'email'            => 'expired@example.com',
            'password'         => bcrypt('password'),
            'token'            => '12345678901234567890',
            'token_expires_at' => Carbon::now()->subHours(25), // Plus de 24h
        ]);

        $service = new AuthenticationService($user);

        expect($service->checkToken('12345678901234567890'))->toBeFalse();
    });

    test('returns false if the token is not identical to the one in database', function () {
        $user = User::query()->create([
            'name'             => 'Wrong Token User',
            'email'            => 'wrong@example.com',
            'password'         => bcrypt('password'),
            'token'            => 'SECRET_TOKEN_12345678',
            'token_expires_at' => Carbon::now()->addHour(),
        ]);

        $service = new AuthenticationService($user);

        expect($service->checkToken('WRONG_TOKEN_SUBMITTED'))->toBeFalse();
    });

    test('returns true if the token and validity date are correct', function () {
        $user = User::query()->create([
            'name'             => 'Valid User',
            'email'            => 'valid@example.com',
            'password'         => bcrypt('password'),
            'token'            => 'VALID_TOKEN_987654321',
            'token_expires_at' => Carbon::now()->addHours(5), // Encore valide
        ]);

        $service = new AuthenticationService($user);

        expect($service->checkToken('VALID_TOKEN_987654321'))->toBeTrue();
    });

});
