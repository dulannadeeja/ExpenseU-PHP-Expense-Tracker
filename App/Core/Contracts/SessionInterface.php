<?php

namespace App\Core\Contracts;

interface SessionInterface
{
    public function __construct(array $config = []);
    public function start(): void;
    public function regenerate(): void;
    public function destroy(): void;
    public function save(): void;
    public function set(string $key, $value): void;

    public function get(string $key);

    public function remove(string $key): void;

    public function isActivated(): bool;
}