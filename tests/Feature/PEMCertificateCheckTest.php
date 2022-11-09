<?php

test('conversion from PEM to DER certificate works', function () {
    $this//->withoutMockingConsoleOutput()
        ->artisan('convert:pem2der',['file' => getcwd().'/tests/stubs/Example_PUBLIC.pem'])
        ->assertOk()
        ->expectsOutputToContain("Example_PUBLIC.DER");
    //dump(\Illuminate\Support\Facades\Artisan::output());
});
