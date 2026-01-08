<?php

use App\Models\User;
use App\Services\AuthenticationService;

/**
 * BUT : Tester la méthode createToken
 * Vérifier :
 * - Un token est ajouté au modèle User (authentication_token)
 * - Le token fait exactement 20 caractères
 * - La date de génération est renseignée
 */
test('createToken adds a 20 characters token to the user', function () {
    $user = User::factory()->create([
        'authentication_token' => null,
        'authentication_token_generated_at' => null,
    ]);

    $service = new AuthenticationService($user);

    $token = $service->createToken();

    $user->refresh();

    expect($token)
        ->toBeString()
        ->toHaveLength(20)
        ->toBe($user->authentication_token)
        ->and($user->authentication_token_generated_at)->not->toBeNull();

    // Bonus utile : vérifier que la date a bien été set
});

/**
 * BUT : Tester la méthode checkToken
 */
describe('checkToken method', function () {

    it('returns false if the token validity exceeds 24h', function () {
        $user = User::factory()->withExpiredToken()->create();

        $service = new AuthenticationService($user);

        expect($service->checkToken($user->authentication_token))->toBeFalse();
    });

    it('returns false if the token is not identical to the one in database', function () {
        $user = User::factory()->withValidToken()->create();

        $service = new AuthenticationService($user);

        expect($service->checkToken('WRONG_TOKEN_SUBMITTED'))->toBeFalse();
    });

    it('returns true if the token and validity date are correct', function () {
        $user = User::factory()->withValidToken()->create();

        $service = new AuthenticationService($user);

        expect($service->checkToken($user->authentication_token))->toBeTrue();
    });

});
