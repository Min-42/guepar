<?php

// src/Service/DocumentGestion.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;

class DocumentGestion
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function supprime($doc)
    {
        $filesystem = new Filesystem();
        $deletedName = 'suppr_'.$doc;
        try {
            $filesystem->rename(
                $this->getTargetDirectory().'/'.$doc,
                $this->getTargetDirectory().'/'.$deletedName
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return true;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}