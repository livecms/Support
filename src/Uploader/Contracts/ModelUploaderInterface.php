<?php

namespace LiveCMS\Support\Uploader\Contracts;

interface ModelUploaderInterface
{
    public function getFileFields();

    public function setFile($field, $file);

    public function deleteFile($field, $file);
}
