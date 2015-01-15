<?php

    /**
     *
     */
    namespace Bas\RoadTaxDataParser\Parser;

    /**
     * Class Parser
     *
     * @package Bas\RoadTaxDataParser\Parser
     */
    class Parser
    {

        /**
         * @var string $uri The location of the data file
         */
        private $uri;

        /**
         *
         * @param string $uri The location of the data file
         */
        public function __construct($uri) {
            $this->uri = $uri;
        }

        /**
         * Formats the data based on all located formatter classes
         *
         * @param array $formatterClasses Every found formatter class
         *
         * @return array The formatted data
         */
        public function formatData(array $formatterClasses) {
            $formattedDataArrays = [];
            foreach ($formatterClasses as $formatterClass) {
                $reflectedClass = new \ReflectionClass($formatterClass);
                if ($reflectedClass->isInstantiable() && $reflectedClass->isSubclassOf($this->getNamespace() . "\\formater\\FormatterInterface.php")) {
                    $formattedDataArrays[] = $reflectedClass->newInstance()
                                                            ->format($this->getData());
                }
            }
            return $formattedDataArrays;
        }

        /**
         * @return string The namespace of this file
         */
        private function getNamespace() {
            return substr($this->getClass(), 0, strrpos($this->getClass(), "\\"));
        }

        /**
         * @return string The class name of this class
         */
        private function getClass() {
            return get_class($this);
        }

        /**
         * @return array The JSON file contents in PHP array format
         */
        private function getData() {
            return json_decode(file_get_contents($this->uri));
        }

        /**
         * Saves the files based on the formatter classes and it's data
         *
         * @param array $formattedDataArrays The formatted data arrays
         */
        public function saveFiles(array $formattedDataArrays) {
            $outputDirectory = dirname($this->uri);
            foreach ($formattedDataArrays as $fileBaseName => $formattedDataArray) {
                file_put_contents("{$outputDirectory}\\{$fileBaseName}.php\\",
                                  "<?php\n\n return " . var_export($formattedDataArray) . ";");
            }
        }

        /**
         * Resolves the locations of the formatter classes
         *
         * @return array The locations of the formatter classes with the file name they should use to print out an php file
         */
        public function locateFormatterClasses() {
            $inputDirectory   = __DIR__ . "/Formatter";
            $formatterClasses = [];
            foreach (new \DirectoryIterator($inputDirectory) as $file) {
                if ($file->isDot()) {
                    continue;
                }
                $formatterClassName                                    = $this->getNamespace() . "\\Formatter\\" . $file->getBasename(".php");
                $formatterClasses[$file->getBasename("Formatter.php")] = $formatterClassName;
            }
            return $formatterClasses;
        }
    }