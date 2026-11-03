<?php

it('refuses to reset sequences when the database is not postgresql', function () {
    $this->artisan('db:reset-sequences')
        ->expectsOutputToContain('PostgreSQL')
        ->assertFailed();
});
