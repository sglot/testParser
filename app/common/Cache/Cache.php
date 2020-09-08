<?php

namespace app\common\Cache;


use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\Cache as DCache;

class Cache extends FilesystemCache implements DCache
{

}