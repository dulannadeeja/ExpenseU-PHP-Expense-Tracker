<?php

namespace App\Core;

use App\Core\Contracts\SessionInterface;
use App\Core\Exceptions\SessionException;

class Session implements SessionInterface
{
    public function __construct(private readonly array $params=[]){}

    // set session
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    // get session
    public function get(string $key)
    {
        return $_SESSION[$key] ?? false;
    }

    // remove session
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @throws SessionException
     */
    public function start(): void
    {
        if($this->isActivated()){
            throw new SessionException('Session already started');
        };

        if(headers_sent($filename, $linenum)){
            throw new SessionException("Headers already sent in $filename on line $linenum");
        }

        // set session cookie params to prevent session hijacking
        session_set_cookie_params([
            'lifetime' => $this->params['session_lifetime'] ?? 999999999,
            'path' => $this->params['session_path'] ?? '/',
            'domain' => $this->params['session_domain'] ?? '',
            'secure' => $this->params['session_secure'] ?? true,
            'httponly' => $this->params['session_httponly'] ?? true,
            'samesite' => $this->params['session_samesite'] ?? 'Lax'
        ]);

        // set session name
        session_name($this->params['session_name'] ?? 'PHPSESSID');

        if(!session_start()){
            throw new SessionException('Session failed to start');
        };

        $this->regenerate();
    }

    public function regenerate(): void
    {
        // regenerate session id to prevent session fixation attacks
        session_regenerate_id(true);
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    public function save(): void
    {
        session_write_close();
    }

    public function isActivated(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }
}