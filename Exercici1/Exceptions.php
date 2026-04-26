<?php
class DivbyZeroException extends DivisionByZeroError
{
    public static function error(int $div): self
    {
        $message = sprintf("Operacion invalida el divisor es igual %d", $div);
        return new self(
            message: $message,
        );
    }
}
