# TODO
For now this is just so i don't forget but this will be better documented later.

if the lib throws an error like this:
```
Fatal error: Uncaught Error: Class "FFI" not found in
```

The php ffi extension is not installed.

then you need to enable it in your php.ini file by adding the following line:

```
extension=ffi
```
