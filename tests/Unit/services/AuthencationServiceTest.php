<?php

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

/**
 * BUT : Tester la méthode createToken
 * Vérifier :
 * - Un token est ajouté au modèle User (authentication_token)
 * - Le token fait exactement 20 caractères
 * - La date de génération est renseignée
 */
test('createToken adds a 20 characters token to the user', function () {
    Carbon::setTestNow(now());

    $user = User::query()->create([
        'name'  => 'Test User',
        'email' => 'test@example.com',
        'authentication_token' => null,
        'authentication_token_generated_at' => null,
    ]);

    $service = new AuthenticationService($user);

    $token = $service->createToken();

    $user->refresh();

    expect($token)->toBeString()
        ->and(strlen($token))->toBe(20)
        ->and($user->authentication_token)->toBe($token)
        ->and($user->authentication_token_generated_at)->not->toBeNull();

    Carbon::setTestNow();
});

/**
 * BUT : Tester la méthode checkToken
 */
describe('checkToken method', function () {

    test('returns false if the token validity exceeds 24h', function () {
        $user = User::query()->create([
            'name'  => 'Expired User',
            'email' => 'expired@example.com',
            'authentication_token' => '12345678901234567890',
            'authentication_token_generated_at' => Carbon::now()->subHours(25),
        ]);

        $service = new AuthenticationService($user);

        expect($service->checkToken('12345678901234567890'))->toBeFalse();
    });

    test('returns false if the token is not identical to the one in database', function () {
        $user = User::query()->create([
            'name'  => 'Wrong Token User',
            'email' => 'wrong@example.com',
            'authentication_token' => 'SECRET_TOKEN_1234567890',
            'authentication_token_generated_at' => Carbon::now(),
        ]);

        $service = new AuthenticationService($user);

        expect($service->checkToken('WRONG_TOKEN_SUBMITTED'))->toBeFalse();
    });

    test('returns true if the token and validity date are correct', function () {
        $user = User::query()->create([
            'name'  => 'Valid User',
            'email' => 'valid@example.com',
            'authentication_token' => 'VALID_TOKEN_9876543210',
            'authentication_token_generated_at' => Carbon::now()->subHours(5),
        ]);

        $service = new AuthenticationService($user);

        expect($service->checkToken('VALID_TOKEN_9876543210'))->toBeTrue();
    });

});
