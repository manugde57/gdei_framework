<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

/**
 * SplClassLoader implementation that implements the technical interoperability
 * standards for PHP 5.3 namespaces and class names.
 *
 * http://groups.google.com/group/php-standards/web/psr-0-final-proposal?pli=1
 *
 *   // Example which loads classes for the Doctrine Common package in the
 *   // Doctrine\Common namespace.
 *   $classLoader = new SplClassLoader('Doctrine\Common', '/path/to/doctrine');
 *   $classLoader->register();
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Roman S. Borschel <roman@code-factory.org>
 * @author Matthew Weier O'Phinney <matthew@zend.com>
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 * @author Fabien Potencier <fabien.potencier@symfony-project.org>
 */
class SplClassLoader
{
    private $namespace;
    private $includePath;
    private $fileExtension = '.php';
    private $namespaceSeparator = "\\";

    /**
     * Create a new <tt>SplClassLoader</tt> that loads classes of the
     * specified namespace
     *
     * @param string $ns The namespace to use
     */
    public function __construct($namespace = null, $includePath = null)
    {
        $this->namespace = $namespace;
        $this->includePath = $includePath;
    }

    /**
     * Set the namespace separator used by classes in the namespace of
     * this class loader
     *
     * @param string $sep The separator to use
     */
    public function setNamespacesSeparator($sep)
    {
        $this->namespaceSeparator = $sep;
    }

    /**
     * Get the namespace separator used by classes in the namespace of
     * this class loader
     *
     * @return void
     */
    public function getNamespaceSeparator()
    {
        return $this->namespaceSeparator;
    }

    /**
     * Set the base include path for all classe files in the namespace of
     * this class loader
     *
     * param string $includePath
     */
    public function setIncludePath($includePath)
    {
        $this->includePath = $includePath;
    }

    /**
     * Get the base include path for all class files in the namespace of
     * this class loader
     *
     * @return void
     */
    public function getIncludePath()
    {
        return $this->includePath;
    }

    /**
     * Set the file extension of class files in the namespace of this class
     * loader
     *
     * @param string $fileExtension
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExension = $fileExtension;
    }

    /**
     * Get the file extension of class files in the namespace of this class
     * loader
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Installs this class loader on the SPL autoload stack
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Uninstall this class loader from the SPL loader stack
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Loads the given class or interface
     *
     * @param string $className The name of the class to load
     * @return void
     */
    public function loadClass($className)
    {
        if (null === $this->namespace
            || $this->namespace . $this->namespaceSeparator === substr(
                $className,
                0,
                strlen($this->namespace . $this->namespaceSeparator)
            )) {
            $fileName = '';
            $namespace = '';
            if (false === ($lastNsPos = strripos(
                $className,
                $this->namespaceSeparator
            ))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace(
                    $this->namespaceSeparator,
                    DIRECTORY_SEPARATOR,
                    $namespace
                ) . DIRECTORY_SEPARATOR;
            }
            $fileName.= str_replace(
                $this->namespaceSeparator,
                DIRECTORY_SEPARATOR,
                $className
            ) . $this->fileExtension;

            require(
                $this->includePath !== null ?
                $this->includePath . DIRECTORY_SEPARATOR :
                ''
            ) . $fileName;
        }
    }
}
