<?php

namespace LiveCMS\Support\File;

class DummyFile
{
    public function __call($method, $arguments)
    {
        return $this;
    }

    public function __toString()
    {
        return '';
    }
}
