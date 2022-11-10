<?php

test('PEM public certificate works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('certificate:check',['file' => getcwd().'/tests/stubs/Example_PUBLIC.pem'])
        ->assertOk()
        ->expectsOutputToContain("Valid until");
    //dump(\Illuminate\Support\Facades\Artisan::output());
});

test('Directory works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('certificate:check-dir',['directory' => getcwd().'/tests/stubs/'])
        ->assertOk()
        ->expectsOutputToContain("Expiration");
    //dump(\Illuminate\Support\Facades\Artisan::output());
});

