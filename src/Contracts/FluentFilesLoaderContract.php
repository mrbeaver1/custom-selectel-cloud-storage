<?php

namespace MrBeaver1\Selectel\CloudStorage\Contracts;

interface FluentFilesLoaderContract
{
    /**
     * Sets directory from where load files.
     *
     * @param string $directory
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\FluentFilesLoaderContract
     */
    public function fromDirectory($directory);

    /**
     * Sets files prefix.
     *
     * @param string $prefix
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\FluentFilesLoaderContract
     */
    public function withPrefix($prefix);

    /**
     * Sets files delimiter.
     *
     * @param string $delimiter
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\FluentFilesLoaderContract
     */
    public function withDelimiter($delimiter);

    /**
     * Sets files limit.
     *
     * @param int    $limit
     * @param string $markerFile = ''
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\FluentFilesLoaderContract
     */
    public function limit($limit, $markerFile = '');

    /**
     * Loads all available files from container.
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\Collections\CollectionContract
     */
    public function all();

    /**
     * Determines whether file exists or not.
     *
     * @param string $path File path.
     *
     * @return bool
     */
    public function exists($path);

    /**
     * Finds single file at given path.
     *
     * @param string $path
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\FileContract
     */
    public function find($path);

    /**
     * Loads files.
     *
     * @return \MrBeaver1\Selectel\CloudStorage\Contracts\Collections\CollectionContract
     */
    public function get();
}
