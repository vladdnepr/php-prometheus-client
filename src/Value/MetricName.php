<?php

declare(strict_types=1);

namespace Enalean\Prometheus\Value;

use InvalidArgumentException;
use function preg_match;
use function sprintf;

/**
 * @psalm-immutable
 */
final class MetricName
{
    private const METRIC_NAME_REGEX = '/^[a-zA-Z_:][a-zA-Z0-9_:]*$/';

    /** @var string */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $namespace e.g. cms
     * @param string $name      e.g. notifications_total
     */
    public static function fromNamespacedName(string $namespace, string $name) : self
    {
        return self::fromName(($namespace ? $namespace . '_' : '') . $name);
    }

    public static function fromName(string $name) : self
    {
        if (! preg_match(self::METRIC_NAME_REGEX, $name)) {
            throw new InvalidArgumentException(sprintf(
                'The name %s does not match the expected pattern.',
                $name
            ));
        }

        return new self($name);
    }

    public function toString() : string
    {
        return $this->name;
    }
}
