<?php

test('PEM public certificate works', function () {
    $this//->withoutMockingConsoleOutput()
        ->artisan('certificate:check',['file' => getcwd().'/tests/stubs/Example_PUBLIC.pem'])
        ->assertOk()
        ->expectsOutputToContain("expiration 06-11-2032");
    //dump(\Illuminate\Support\Facades\Artisan::output());
});

test('Directory works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('certificate:check-dir',['directory' => getcwd().'/tests/stubs/'])
        ->assertOk()
        ->expectsOutputToContain("expiration 06-11-2032");
    //dump(\Illuminate\Support\Facades\Artisan::output());
});