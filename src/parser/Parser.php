<?php

    /**
     *
     */
    namespace SRC\Parser;

    /**
     * Class Parser
     *
     * @package SRC\Parser
     */
    class Parser
    {

        /**
         * @var
         */
        private $uri;

        /**
         * @param $uri
         */
        public function __construct($uri) {
            $this->uri = $uri;
        }

        /**
         * @return string
         */
        public function getData() {
            return json_decode(file_get_contents($this->uri));
        }

        /**
         * @param array $formatterClasses
         */
        public function formatData(array $formatterClasses) {
            foreach ($formatterClasses as $formatterClass) {
                $reflectedClass = new \ReflectionClass($formatterClass);

                if ($reflectedClass->isInstantiable()) {
                    $reflectedClass->newInstance()
                                   ->format();
                }
            }
        }


        /**
         * @return array
         */
        private function locateFormatterClasses() {
            $inputDirectory   = __DIR__ . "/formatter";
            $formatterClasses = [];
            foreach (new \DirectoryIterator($inputDirectory) as $file) {
                if ($file->isDot()) {
                    continue;
                }
                $formatterClassName = $this->getNamespace() . "\\Formatter\\" . $file->getBasename(".php");
                $formatterClasses[] = $formatterClassName;
            }
            return $formatterClasses;
        }

        /**
         * @return string
         */
        private function getNamespace() {
            return substr($this->getClass(), 0, strrpos($this->getClass(), "\\"));
        }

        /**
         * @return string
         */
        private function getClass() {
            return get_class($this);
        }
    }