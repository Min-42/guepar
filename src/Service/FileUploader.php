<?php

// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $documentOriginalName = $file->getClientOriginalName();
        $documentExtension = $file->guessExtension();
        $documentSize = $file->getClientSize();

        $documentName = md5(uniqid()).'.'.$documentExtension;

        try {
            $file->move($this->getTargetDirectory(), $documentName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return [
            'documentName' => $documentName,
            'documentOriginalName' => $documentOriginalName,
            'documentExtension' => $documentExtension,
            'documentSize' => $documentSize,
        ];
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}