# PHP-Insider
PHP-Insider is a static application security testing tool (SAST), which is specialized in finding dangerous sinks.
It's not designed to be a fully-automated tool for identifying vulnerabilities, but rather an aid for analysts finding them.

## Basic usage
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

## Testing
```shell
composer test
```

## Security Vulnerabilities
If you discovered a security vulnerability, please send an e-mail to [jeremy.angele@proton.me](mailto:jeremy.angele@proton.me). All security vulnerabilities will be promptly addressed.