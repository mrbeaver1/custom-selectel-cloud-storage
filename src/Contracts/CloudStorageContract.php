<?php

namespace MrBeaver1\Selectel\CloudStorage\Contracts;

interface CloudStorageContract
{
    /**
     * Available containers.
     *
     * @param int    $limit  = 10000
     * @param string $marker = ''
     *
     * @throws \MrBeaver1\Selectel\CloudStorage\Exceptions\ApiRequestFailedException
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\Collections\CollectionContract
     */
    public function containers($limit = 10000, $marker = '');

    /**
     * Retrieves single container from cloud storage.
     *
     * @param string $name
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\ContainerContract
     */
    public function getContainer($name);

    /**
     * Creates new container.
     *
     * @param string $name
     * @param string $type
     *
     * @throws \InvalidArgumentException
     * @throws \MrBeaver1\Selectel\CloudStorage\Exceptions\ApiRequestFailedException
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\ContainerContract
     */
    public function createContainer($name, $type = 'public');
}
