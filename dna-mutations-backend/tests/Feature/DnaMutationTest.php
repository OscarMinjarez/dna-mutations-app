<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;


uses(RefreshDatabase::class);

it("Return 200 OK when mutation is detected", function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $dna = [
        "ATGCGA",
        "CAGTGC",
        "TTATGT",
        "AGAAGG",
        "CCCCTA",
        "TCACTG"
    ];
    $response = $this->postJson("api/mutation", ["dna" => $dna]);
    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has("message")
                ->where("message", __("messages.mutation_detected"))
                ->has("dna")
                ->where("mutation", true)
                ->etc()
        );
});

it("Return 403 Forbidden when no mutation is detected", function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $dna = [
        "ATGCGA",
        "CAGTGC",
        "TTATGT",
        "AGACGG",
        "CCTCTA",
        "TCACTG"
    ];
    $response = $this->postJson("api/mutation", ["dna" => $dna]);
    $response->assertStatus(403)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has("message")
                ->where("message", __("messages.no_mutation_detected"))
                ->has("dna")
                ->where("mutation", false)
                ->etc()
        );
});

it("Return 422 Unprocessable Entity when DNA is null", function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $dna = null;
    $response = $this->postJson("api/mutation", ["dna" => $dna]);
    $response->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has("error")
                ->where("error", __("errors.dna_must_be_array"))
                ->etc()
        );
});

it("Return 422 Unprocessable Entity when DNA has invalid characters", function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $dna = [
        "ATGFGA",
        "CAGTGC",
        "TTATLT",
        "AGACGG",
        "CWTCSA",
        "TDACTG"
    ];
    $response = $this->postJson("api/mutation", ["dna" => $dna]);
    $response->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has("error")
                ->where("error", __("errors.dna_invalid_characters"))
                ->etc()
        );
});