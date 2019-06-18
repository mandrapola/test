<?php


interface StorageProviderInterface
{
    public function getData(): array;
    public function storeData(array $data);
}