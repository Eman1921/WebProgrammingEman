<?php

class HttpException extends RuntimeException
{
    protected int $status;

    public function __construct(string $message, int $status)
    {
        parent::__construct($message);
        $this->status = $status;
    }

    public function get_status(): int
    {
        return $this->status;
    }
}

class ValidationException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}

class UnauthorizedException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 401);
    }
}

class ForbiddenException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 403);
    }
}

class NotFoundException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 404);
    }
}

class ExternalServiceException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 503);
    }
}
