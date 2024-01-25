<?php

declare(strict_types=1);

namespace BaseValueObject;

use JsonSerializable;
use Stringable;

/**
 * Class ValueObject
 * @package ValueObject
 */
abstract class ValueObject implements JsonSerializable, Stringable
{
}
