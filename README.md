# PHP-Insider
PHP-Insider is a static application security testing tool (SAST), which is specialized in finding dangerous sinks.
It's not designed to be a fully-automated tool for identifying vulnerabilities, but rather an aid for analysts finding them.

> **Warning!** This repository is currently under development and may contain breaking changes.

## Basic Usage
```shell
insider@linux:~$ ./bin/insider analyse src/
   ExecSink  found in file src/Command.php › Ⓒ Command › ⓜ execute 
        5▕     public function execute(string $cmd){
        6▕ 
    ➜   7▕         return exec($cmd);
        8▕     }
        9▕ }


   Summary:  1 sink found
```

## Supported Sinks
### Code Execution
- [`` `backtick` ``](https://www.php.net/manual/en/language.operators.execution)
- [`eval()`](https://www.php.net/manual/en/function.eval)
- [`exec()`](https://www.php.net/manual/en/function.exec)
- [`passthru()`](https://www.php.net/manual/en/function.passthru)
- [`pcntl_exec()`](https://www.php.net/manual/en/function.pcntl-exec)
- [`popen()`](https://www.php.net/manual/en/function.popen)
- [`proc_open()`](https://www.php.net/manual/en/function.proc-open)
- [`shell_exec()`](https://www.php.net/manual/en/function.shell-exec)
- [`system()`](https://www.php.net/manual/en/function.system)

### File Inclusion
- [`include()`](https://www.php.net/manual/en/function.include)
- [`include_once()`](https://www.php.net/manual/en/function.include-once)
- [`require()`](https://www.php.net/manual/en/function.require)
- [`require_once()`](https://www.php.net/manual/en/function.require-once)

### File Read
- [`file_get_contents()`](https://www.php.net/manual/en/function.file-get-contents)
- [`file()`](https://www.php.net/manual/en/function.file)
- [`readfile()`](https://www.php.net/manual/en/function.readfile)

### File Write
- [`copy()`](https://www.php.net/manual/en/function.copy)
- [`file_put_contents()`](https://www.php.net/manual/en/function.file-put-contents)

### Information Disclosure
- [`phpinfo()`](https://www.php.net/manual/en/function.phpinfo)

<br/>

## Testing
```shell
composer test
```

## Security Vulnerabilities
If you discovered a security vulnerability, please send an e-mail to [jeremy.angele@proton.me](mailto:jeremy.angele@proton.me). All security vulnerabilities will be promptly addressed.
