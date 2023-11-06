<?php

namespace Wiilon\EnumBooster;

use Hyperf\Engine\Channel;
use Wiilon\EnumBooster\Annotation\Invoke;

enum EnumBoosterDemo: int
{
    use EnumBooster;


    case A = 1;
}
