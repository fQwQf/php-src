--TEST--
SCCP must not propagate array writes with null keys (emits deprecation at run-time)
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
function f1() { $a = []; $q = $a; $q[null] = 99; return $a === $q; }
function f2() { $a = []; $a[null] = 'v'; return $a; }
function f3() { $s = false; $s[null] = 'v'; return $s; }  // also loses false->array deprecation
var_dump(f1());
var_dump(f2());
var_dump(f3());
--EXPECTF--
H:Using null as an array offset is deprecated, use an empty string instead
bool(false)
H:Using null as an array offset is deprecated, use an empty string instead
array(1) {
  [""]=>
  string(1) "v"
}
H:Automatic conversion of false to array is deprecated
H:Using null as an array offset is deprecated, use an empty string instead
array(1) {
  [""]=>
  string(1) "v"
}
