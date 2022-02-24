<?php

namespace Mrbeaver1\Selectel\CloudStorage;

use InvalidArgumentException;
use Mrbeaver1\Selectel\CloudStorage\Collections\Collection;
use Mrbeaver1\Selectel\CloudStorage\Contracts\CloudStorageContract;
use Mrbeaver1\Selectel\CloudStorage\Contracts\Api\ApiClientContract;
use Mrbeaver1\Selectel\CloudStorage\Exceptions\ApiRequestFailedException;

class CloudStorage implements CloudStorageContract
{
    /**
     * API Client instance.
     *
     * @var \Mrbeaver1\Selectel\CloudStorage\Contracts\Api\ApiClientContract
     */
    protected $api;

    /**
     * File uploader.
     *
     * @var \Mrbeaver1\Selectel\CloudStorage\FileUploader
     */
    protected $uploader;

    /**
     * Creates new instance.
     *
     * @param \Mrbeaver1\Selectel\CloudStorage\Contracts\Api\ApiClientContract $api
     */
    public function __construct(ApiClientContract $api)
    {
        $this->api = $api;
        $this->uploader = new FileUploader();
    }

    /**
     * Available containers.
     *
     * @param int    $limit  = 10000
     * @param string $marker = ''
     *
     * @throws \Mrbeaver1\Selectel\CloudStorage\Exceptions\ApiRequestFailedException
     *
     * @return \Mrbeaver1\Selectel\CloudStorage\Contracts\Collections\CollectionContract
     */
    public function containers($limit = 10000, $marker = '')
    {
        $response = $this->api->request('GET', '/', [
            'query' => [
                'limit' => intval($limit),
                'marker' => $marker,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new ApiRequestFailedException('Unable to list containers.', $response->getStatusCode());
        }

        $containers = json_decode($response->getBody(), true);

        return new Collection($this->transformContainers($containers));
    }

    /**
     * Retrieves single container from cloud storage.
     *
     * @param string $name
     *
     * @return \Mrbeaver1\Selectel\CloudStorage\Contracts\ContainerContract
     */
    public function getContainer($name)
    {
        return new Container($this->api, $this->uploader, $name);
    }

    /**
     * Creates new container.
     *
     * @param string $name
     * @param string $type
     *
     * @throws \InvalidArgumentException
     * @throws \Mrbeaver1\Selectel\CloudStorage\Exceptions\ApiRequestFailedException
     *
     * @return \Mrbeaver1\Selectel\CloudStorage\Contracts\ContainerContract
     */
    public function createContainer($name, $type = 'public')
    {
        if (!in_array($type, ['public', 'private', 'gallery'])) {
            throw new InvalidArgumentException('Unknown type "'.$type.'" provided.');
        }

        $response = $this->api->request('PUT', '/'.trim($name, '/'), [
            'headers' => [
                'X-Container-Meta-Type' => $type,
            ],
        ]);

        switch ($response->getStatusCode()) {
            case 201:
                return $this->getContainer(trim($name, '/'));
            case 202:
                throw new ApiRequestFailedException('Container "'.$name.'" already exists.');
            default:
                throw new ApiRequestFailedException('Unable to create container "'.$name.'".', $response->getStatusCode());
        }
    }

    /**
     * Transforms containers response to Container objects.
     *
     * @param array $items
     *
     * @return array
     */
    protected function transformContainers(array $items)
    {
        if (!count($items)) {
            return [];
        }

        $containers = [];

        foreach ($items as $item) {
            $container = new Container($this->api, $this->uploader, $item['name'], $item);
            $containers[$container->name()] = $container;
        }

        return $containers;
    }
}
