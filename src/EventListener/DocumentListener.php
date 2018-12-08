<?php

// src/EventListener/DocumentListener.php
namespace App\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Document;
use App\Service\DocumentGestion;

class DocumentListener
{
    private $documentGestion;

    public function __construct(DocumentGestion $documentGestion) {
        $this->documentGestion = $documentGestion;
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // N'agit que sur les instances de type Document
        if (!$entity instanceof Document) {
            return;
        }

        if ($args->hasChangedField('documentName')) {
            $newValue = $args->getNewValue('documentName');
            $oldValue = $args->getOldValue('documentName');
            if ($newValue === Null) {
                $entity->setDocumentName($oldValue);
            } else {
                $this->documentGestion->supprime($oldValue);
            }
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // N'agit que sur les instances de type Document
        if (!$entity instanceof Document) {
            return;
        }

        $docNameValue = $entity->getDocumentName()->getFilename();
        $this->documentGestion->supprime($docNameValue);
    }
}