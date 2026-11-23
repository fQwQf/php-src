--TEST--
DCE must not remove dead ADD_ARRAY_ELEMENT reading an undefined variable
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.optimization_level=0x7FFEBFFF
opcache.jit=0
--EXTENSIONS--
opcache
--FILE--
<?php
set_error_handler(function($no, $str) { echo "H:$str\n"; return true; });
function f() { $r = [$x, $y]; return 1; }
f();
--EXPECT--
H:Undefined variable $x
H:Undefined variable $y
