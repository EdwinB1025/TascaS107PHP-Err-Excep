<?php
trait handleException
{
    public function printException(): void
    {
        echo "<b>Exception: </b>" . $this->getMessage() . "<br />\n";
        echo "Codigo: " . $this->getCode() . "<br />\n";
    }
}

class notNumericException extends \Exception
{
    public static function validate(string $d): self
    {
        $message = sprintf("The value of the age passed is not numeric: %s, $d");
        return new self(
            message: $message,
            code: 403
        );
    }

    use handleException;
}

class outOfRangeAgeException extends \Exception
{
    public static function validate(string $d): self
    {
        $message = sprintf("The value of the age passed is out of range (0-120): %d, $d");
        return new self(
            message: $message,
            code: 403
        );
    }

    use handleException;
}


class genericStringException extends \Exception
{
    public static function validate(string $s, string $n): self
    {
        $message = sprintf("The value of the field %s passed is not valid: %s", $s, $n);
        return new self(
            message: $message,
            code: 403
        );
    }

    use handleException;
}

function exceptionHandler($e): void
{
    http_response_code($e->getCode());

    match (true) {
        $e instanceof notNumericException,
        $e instanceof outOfRangeAgeException,
        $e instanceof genericStringException => $e->printException(),
        default => printf("<b>Exception: </b> %s <br /> Codigo: %d <br />\n", $e->getMessage(), $e->getCode())
    };
}
