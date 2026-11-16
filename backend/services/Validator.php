<?php

class Validator
{
    public static function required(array $data, array $fields): void
    {
        foreach ($fields as $field) {
            if (!array_key_exists($field, $data)
                || $data[$field] === null
                || (is_string($data[$field]) && trim($data[$field]) === '')) {
                throw new ValidationException("Field '{$field}' is required.");
            }
        }
    }

    public static function string(array $data, string $field, int $min, int $max, bool $optional = false): void
    {
        if ($optional && (!array_key_exists($field, $data) || $data[$field] === null)) {
            return;
        }

        if (!isset($data[$field]) || !is_string($data[$field])) {
            throw new ValidationException("Field '{$field}' must be text.");
        }

        $length = strlen(trim($data[$field]));
        if ($length < $min || $length > $max) {
            throw new ValidationException("Field '{$field}' must be between {$min} and {$max} characters long.");
        }
    }

    public static function integer(array $data, string $field, int $min, int $max): int
    {
        $value = $data[$field] ?? null;
        if (!is_int($value) && (!is_string($value) || !preg_match('/^-?[0-9]+$/', $value))) {
            throw new ValidationException("Field '{$field}' must be a whole number.");
        }

        $value = (int) $value;
        if ($value < $min || $value > $max) {
            throw new ValidationException("Field '{$field}' must be between {$min} and {$max}.");
        }

        return $value;
    }

    public static function number(array $data, string $field, float $min): float
    {
        $value = $data[$field] ?? null;
        if (!is_numeric($value)) {
            throw new ValidationException("Field '{$field}' must be a number.");
        }

        $value = (float) $value;
        if ($value < $min) {
            throw new ValidationException("Field '{$field}' must be at least {$min}.");
        }

        return $value;
    }

    public static function choice(array $data, string $field, array $choices): string
    {
        $value = $data[$field] ?? null;
        if (!is_string($value) || !in_array($value, $choices, true)) {
            throw new ValidationException("Field '{$field}' has an invalid value.");
        }

        return $value;
    }
}
