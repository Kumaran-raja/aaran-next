<?php

test('AaranServiceProvider loads modules correctly', function () {
    $this->assertTrue(class_exists(\Aaran\Core\Providers\AaranServiceProvider::class));
});
