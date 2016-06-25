<?php

namespace LiveCMS\Support\Uploader;

class DummyFile
{
    public function __call($method, $arguments)
    {
        return $this;
    }
}
