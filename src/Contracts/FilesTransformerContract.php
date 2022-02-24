<?php

namespace MrBeaver\Selectel\CloudStorage\Contracts;

interface FilesTransformerContract
{
    /**
     * Transforms file array to instance of File object.
     *
     * @param array $file File array.
     *
     * @return \MrBeaver\Selectel\CloudStorage\Contracts\FileContract
     */
    public function getFileFromArray(array $file);

    /**
     * Transforms Collection of file arrays (or plain array) to Collection of File objects.
     * Warning: converting a lot of files to `File` instances may result in performance loss.
     *
     * @param array|\MrBeaver\Selectel\CloudStorage\Collections\Collection $files
     *
     * @return \MrBeaver\Selectel\CloudStorage\Collections\Collection
     */
    public function getFilesCollectionFromArrays($files);
}
