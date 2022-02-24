<?php

namespace MrBeaver\Selectel\CloudStorage\Traits;

use MrBeaver\Selectel\CloudStorage\File;
use MrBeaver\Selectel\CloudStorage\Collections\Collection;

trait FilesTransformer
{
    /**
     * Container name. This name will be used in transformation process.
     *
     * @return string
     */
    abstract public function containerName();

    /**
     * API Client.
     *
     * @return \MrBeaver\Selectel\CloudStorage\Contracts\Api\ApiClientContract
     */
    abstract public function apiClient();

    /**
     * Transforms file array to instance of File object.
     *
     * @param array $file File array.
     *
     * @return \MrBeaver\Selectel\CloudStorage\Contracts\FileContract
     */
    public function getFileFromArray(array $file)
    {
        return new File($this->apiClient(), $this->containerName(), $file);
    }

    /**
     * Transforms Collection of file arrays (or plain array) to Collection of File objects.
     * Warning: converting a lot of files to `File` instances may result in performance loss.
     *
     * @param array|\MrBeaver\Selectel\CloudStorage\Collections\Collection $files
     *
     * @return \MrBeaver\Selectel\CloudStorage\Collections\Collection
     */
    public function getFilesCollectionFromArrays($files)
    {
        $collection = new Collection();

        foreach ($files as $file) {
            $collection[] = $this->getFileFromArray($file);
        }

        return $collection;
    }
}
