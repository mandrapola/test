<?php


require_once 'StorageProviderInterface.php';

class FileStorageProvider implements StorageProviderInterface
{
    const PATH_CONFIG = __DIR__.'/config/cron.json';
    /**
     * @var bool|resource
     */
    private $file;

    /**
     * @return array
     */
    public function getData(): array
    {
        if (!file_exists(self::PATH_CONFIG)) {
            return [];
        }
        $this->file = fopen(self::PATH_CONFIG, 'r+');

        if (false === $this->file) {
            return [];
        }
            flock($this->file, LOCK_EX | LOCK_SH);
            $jsonData = '';
            while (!feof($this->file)) {
                $jsonData .= fgets($this->file);
            }

            return json_decode($jsonData,true);
    }

    /**
     * @param array $data
     *
     * @throws Exception
     */
    public function storeData(array $data)
    {
        if (null === $this->file) {
            $this->file = fopen(self::PATH_CONFIG, 'w+');
        }
        ftruncate($this->file, 0);
        rewind($this->file);
        fwrite($this->file, json_encode($data));
        sleep(30);
        fclose($this->file);
    }
}