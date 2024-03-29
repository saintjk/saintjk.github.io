<?php 

function register($namespace, $path) { 
    spl_autoload_register(function ($class) use ($namespace, $path) {
        // project-specific namespace prefix
        $prefix = 'EA\\' . $namespace . '\\';

        // does the class use the namespace prefix?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // no, move to the next registered autoloader
            return;
        }

        // get the relative class name
        $relative_class = substr($class, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $path . '/' . str_replace('\\', '/', $relative_class) . '.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        }
    });
}

register('Engine', __DIR__ . '/engine'); 
