<?php
    /**
     * PHPUnit
     *
     * Copyright (c) 2010-2014, Sebastian Bergmann <sebastian@phpunit.de>.
     * All rights reserved.
     *
     * Redistribution and use in source and binary forms, with or without
     * modification, are permitted provided that the following conditions
     * are met:
     *
     *   * Redistributions of source code must retain the above copyright
     *     notice, this list of conditions and the following disclaimer.
     *
     *   * Redistributions in binary form must reproduce the above copyright
     *     notice, this list of conditions and the following disclaimer in
     *     the documentation and/or other materials provided with the
     *     distribution.
     *
     *   * Neither the name of Sebastian Bergmann nor the names of his
     *     contributors may be used to endorse or promote products derived
     *     from this software without specific prior written permission.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
     * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
     * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
     * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
     * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
     * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
     * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
     * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
     * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
     * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
     * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
     * POSSIBILITY OF SUCH DAMAGE.
     *
     * @package    PHPUnit_MockObject
     * @author     Sebastian Bergmann <sebastian@phpunit.de>
     * @copyright  2010-2014 Sebastian Bergmann <sebastian@phpunit.de>
     * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
     * @link       http://github.com/sebastianbergmann/phpunit-mock-objects
     * @since      File available since Release 1.0.0
     */

    /**
     * Main matcher which defines a full expectation using method, parameter and
     * invocation matchers.
     * This matcher encapsulates all the other matchers and allows the builder to
     * set the specific matchers when the appropriate methods are called (once(),
     * where() etc.).
     *
     * All properties are public so that they can easily be accessed by the builder.
     *
     * @package    PHPUnit_MockObject
     * @author     Sebastian Bergmann <sebastian@phpunit.de>
     * @copyright  2010-2014 Sebastian Bergmann <sebastian@phpunit.de>
     * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
     * @version    Release: @package_version@
     * @link       http://github.com/sebastianbergmann/phpunit-mock-objects
     * @since      Class available since Release 1.0.0
     */
    class PHPUnit_Framework_MockObject_Matcher implements PHPUnit_Framework_MockObject_Matcher_Invocation
    {
        /**
         * @var PHPUnit_Framework_MockObject_Matcher_Invocation
         */
        public $invocationMatcher;

        /**
         * @var mixed
         */
        public $afterMatchBuilderId = null;

        /**
         * @var boolean
         */
        public $afterMatchBuilderIsInvoked = false;

        /**
         * @var PHPUnit_Framework_MockObject_Matcher_MethodName
         */
        public $methodNameMatcher = null;

        /**
         * @var PHPUnit_Framework_MockObject_Matcher_Parameters
         */
        public $parametersMatcher = null;

        /**
         * @var PHPUnit_Framework_MockObject_Stub
         */
        public $stub = null;

        /**
         * @param PHPUnit_Framework_MockObject_Matcher_Invocation $invocationMatcher
         */
        public function __construct(PHPUnit_Framework_MockObject_Matcher_Invocation $invocationMatcher) {
            $this->invocationMatcher = $invocationMatcher;
        }

        /**
         * @return string
         */
        public function toString() {
            $list = array();

            if ($this->invocationMatcher !== null) {
                $list[] = $this->invocationMatcher->toString();
            }

            if ($this->methodNameMatcher !== null) {
                $list[] = 'where ' . $this->methodNameMatcher->toString();
            }

            if ($this->parametersMatcher !== null) {
                $list[] = 'and ' . $this->parametersMatcher->toString();
            }

            if ($this->afterMatchBuilderId !== null) {
                $list[] = 'after ' . $this->afterMatchBuilderId;
            }

            if ($this->stub !== null) {
                $list[] = 'will ' . $this->stub->toString();
            }

            return join(' ', $list);
        }

        /**
         * @param  PHPUnit_Framework_MockObject_Invocation $invocation
         *
         * @return mixed
         */
        public function invoked(PHPUnit_Framework_MockObject_Invocation $invocation) {
            if ($this->invocationMatcher === null) {
                throw new PHPUnit_Framework_Exception('No invocation matcher is set');
            }

            if ($this->methodNameMatcher === null) {
                throw new PHPUnit_Framework_Exception('No method matcher is set');
            }

            if ($this->afterMatchBuilderId !== null) {
                $builder = $invocation->object->__phpunit_getInvocationMocker()
                                              ->lookupId($this->afterMatchBuilderId);

                if (!$builder) {
                    throw new PHPUnit_Framework_Exception(sprintf('No builder found for match builder identification <%s>',
                                                                  $this->afterMatchBuilderId));
                }

                $matcher = $builder->getMatcher();

                if ($matcher && $matcher->invocationMatcher->hasBeenInvoked()) {
                    $this->afterMatchBuilderIsInvoked = true;
                }
            }

            $this->invocationMatcher->invoked($invocation);

            try {
                if ($this->parametersMatcher !== null && !$this->parametersMatcher->matches($invocation)) {
                    $this->parametersMatcher->verify();
                }
            } catch (PHPUnit_Framework_ExpectationFailedException $e) {
                throw new PHPUnit_Framework_ExpectationFailedException(sprintf("Expectation failed for %s when %s\n%s",
                                                                               $this->methodNameMatcher->toString(),
                                                                               $this->invocationMatcher->toString(),
                                                                               $e->getMessage()),
                                                                       $e->getComparisonFailure());
            }

            if ($this->stub) {
                return $this->stub->invoke($invocation);
            }

            return null;
        }

        /**
         * @param  PHPUnit_Framework_MockObject_Invocation $invocation
         *
         * @return boolean
         */
        public function matches(PHPUnit_Framework_MockObject_Invocation $invocation) {
            if ($this->afterMatchBuilderId !== null) {
                $builder = $invocation->object->__phpunit_getInvocationMocker()
                                              ->lookupId($this->afterMatchBuilderId);

                if (!$builder) {
                    throw new PHPUnit_Framework_Exception(sprintf('No builder found for match builder identification <%s>',
                                                                  $this->afterMatchBuilderId));
                }

                $matcher = $builder->getMatcher();

                if (!$matcher) {
                    return false;
                }

                if (!$matcher->invocationMatcher->hasBeenInvoked()) {
                    return false;
                }
            }

            if ($this->invocationMatcher === null) {
                throw new PHPUnit_Framework_Exception('No invocation matcher is set');
            }

            if ($this->methodNameMatcher === null) {
                throw new PHPUnit_Framework_Exception('No method matcher is set');
            }

            if (!$this->invocationMatcher->matches($invocation)) {
                return false;
            }

            try {
                if (!$this->methodNameMatcher->matches($invocation)) {
                    return false;
                }
            } catch (PHPUnit_Framework_ExpectationFailedException $e) {
                throw new PHPUnit_Framework_ExpectationFailedException(sprintf("Expectation failed for %s when %s\n%s",
                                                                               $this->methodNameMatcher->toString(),
                                                                               $this->invocationMatcher->toString(),
                                                                               $e->getMessage()),
                                                                       $e->getComparisonFailure());
            }

            return true;
        }

        /**
         * @throws PHPUnit_Framework_Exception
         * @throws PHPUnit_Framework_ExpectationFailedException
         */
        public function verify() {
            if ($this->invocationMatcher === null) {
                throw new PHPUnit_Framework_Exception('No invocation matcher is set');
            }

            if ($this->methodNameMatcher === null) {
                throw new PHPUnit_Framework_Exception('No method matcher is set');
            }

            try {
                $this->invocationMatcher->verify();

                if ($this->parametersMatcher === null) {
                    $this->parametersMatcher = new PHPUnit_Framework_MockObject_Matcher_AnyParameters;
                }

                $invocationIsAny   = get_class($this->invocationMatcher) === 'PHPUnit_Framework_MockObject_Matcher_AnyInvokedCount';
                $invocationIsNever = get_class($this->invocationMatcher) === 'PHPUnit_Framework_MockObject_Matcher_InvokedCount' && $this->invocationMatcher->isNever();
                if (!$invocationIsAny && !$invocationIsNever) {
                    $this->parametersMatcher->verify();
                }
            } catch (PHPUnit_Framework_ExpectationFailedException $e) {
                throw new PHPUnit_Framework_ExpectationFailedException(sprintf("Expectation failed for %s when %s.\n%s",
                                                                               $this->methodNameMatcher->toString(),
                                                                               $this->invocationMatcher->toString(),
                                                                               PHPUnit_Framework_TestFailure::exceptionToString($e)));
            }
        }

        /**
         * @since Method available since Release 1.2.4
         */
        public function hasMatchers() {
            if ($this->invocationMatcher !== null && !$this->invocationMatcher instanceof PHPUnit_Framework_MockObject_Matcher_AnyInvokedCount) {
                return true;
            }

            return false;
        }
    }
