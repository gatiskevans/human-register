<?php

    namespace App;

    use League\Csv\Reader;
    use League\Csv\Writer;
    use League\Csv\Statement;

    class DataHandler
    {
        private Reader $csv;
        private Writer $csvWriter;
        private array $header;
        private array $records;
        private string $path;

        public function __construct(string $path)
        {
            $this->path = $path;
            $this->csv = Reader::createFromPath($path, 'r');
            $this->csv->setHeaderOffset(0);
            $this->csvWriter = Writer::createFromPath($path, 'r+');
            $this->header = $this->csv->getHeader();

        }

        public function getCsv(): Reader
        {
            return $this->csv;
        }

        public function insert(string $name, string $surname, string $id, string $info = null): void
        {
            $this->csvWriter->insertOne($this->header);
            foreach(Statement::create()->process($this->csv) as $record){
                $this->records[] = $record;
            }
            $this->records[] = [$_POST[$name], $_POST[$surname], $_POST[$id], $_POST[$info]];
            $this->csvWriter->insertAll($this->records);
        }

        public function delete(array $person): void
        {
            foreach(Statement::create()->process($this->csv) as $record){
                if($person !== $record) $this->records[] = $record;
            }
            file_put_contents($this->path, "");
            $this->csvWriter->insertOne($this->header);
            $this->csvWriter->insertAll($this->records);
        }
    }