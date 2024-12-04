<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Event;

class UploadSubscriber implements EventSubscriberInterface
{
    private string $projectDir;
    public function __construct(
        string $projectDir,
        private EntityManagerInterface $em
    )
    {
        $this->projectDir = $projectDir;
    }
    public function onPostUpload(Event $event): void
    {
        // dd($_FILES['file']);
        $object = $event->getObject();
        $filePath = $this->projectDir . '/public/Upload/' . $object->getFile()->getFileName();
        $to = $this->projectDir . '/public/Upload/' . $object->getEntity() . '/' . $object->getContext() . '/' . $object->getName() . '/end';

        $destinationPath = dirname($to);
        if(!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $to = str_replace('/end', '', $to) . '/' . $object->getFile()->getFileName();

        $is_move = rename($filePath, $to);

        if ($is_move && file_exists($filePath)) {
            unlink($filePath);
        }
        
        $path = str_replace( $this->projectDir . '/public', '', $to);
        $object->setFilePath($path);

    }

    public static function getSubscribedEvents(): array
    {
        return [
            'vich_uploader.post_upload' => 'onPostUpload',
        ];
    }
}
