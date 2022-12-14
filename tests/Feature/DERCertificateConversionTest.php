<?php

test('conversion from PEM to DER certificate works', function () {
    $this//->withoutMockingConsoleOutput()
    ->artisan('convert:der2pem',['file' => getcwd().'/tests/stubs/Example_PUBLIC.DER'])
        ->assertOk()
        ->expectsOutputToContain("Example_PUBLIC.PEM");
    //dump(\Illuminate\Support\Facades\Artisan::output());
});