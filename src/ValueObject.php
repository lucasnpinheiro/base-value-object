<?php

declare(strict_types=1);

namespace App;

use JsonSerializable;
use Stringable;

abstract class ValueObject implements JsonSerializable, Stringable
{
}
