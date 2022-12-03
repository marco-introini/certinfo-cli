<?php

test('PEM public certificate works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('check:file',['file' => getcwd().'/tests/stubs/Example_PUBLIC.pem'])
        ->assertOk()
        ->expectsOutputToContain("Valid until");
});

test('Directory works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('check:directory',['directory' => getcwd().'/tests/stubs/'])
        ->assertOk()
        ->expectsOutputToContain("Expiration");
});

test('URL works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('check:url',['url' => 'https://google.com'])
        ->assertOk()
        ->expectsOutputToContain("Valid until");
});

