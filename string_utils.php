<?php
/**
 * string_utils.php — 字符串工具函数与自带简易测试.
 *
 * 直接运行测试: php string_utils.php
 * 引入使用:     require 'string_utils.php';  (引入时无任何输出)
 *
 * 无外部依赖、不使用 PHPUnit、不连接数据库。
 */

/**
 * 反转字符串.
 *
 * mbstring 可用时按字符反转（多字节文本不乱码），否则退化为按字节反转 strrev。
 * 入参故意不加 string 类型约束：非字符串入参需要返回空字符串而不是抛 TypeError。
 *
 * @param mixed $str 待反转的字符串
 * @return string 反转后的字符串；$str 不是字符串（含 null、数字、布尔、数组、对象）时返回空字符串
 */
function reverse_string($str)
{
    if (!is_string($str) || $str === '') {
        return '';
    }

    if (function_exists('mb_str_split')) {
        return implode('', array_reverse(mb_str_split($str)));
    }

    return strrev($str);
}

/**
 * reverse_string 的简易断言测试，不依赖 PHPUnit.
 *
 * 覆盖正常输入 7 例、非字符串与边界 7 例、多字节 1 例；
 * 缺少 mbstring 时多字节用例记为 SKIP，其余 14 例照常判定。
 *
 * @return int 失败用例数量，0 表示全部通过
 */
function test_reverse_string()
{
    $cases = [
        ['ascii', 'hello', 'olleh', false],
        ['single-char', 'a', 'a', false],
        ['empty', '', '', false],
        ['digits', '12345', '54321', false],
        ['punct-space', 'Hello, World!', '!dlroW ,olleH', false],
        ['inner-space', 'ab cd', 'dc ba', false],
        ['palindrome', 'level', 'level', false],
        ['null', null, '', false],
        ['int', 123, '', false],
        ['float', 1.5, '', false],
        ['bool-true', true, '', false],
        ['bool-false', false, '', false],
        ['array', [1, 2], '', false],
        ['object', new stdClass(), '', false],
        ['multibyte', '中文测试', '试测文中', true],
    ];

    $passed = 0;
    $failed = 0;
    $skipped = 0;

    foreach ($cases as $case) {
        list($name, $input, $expected, $needMb) = $case;

        if ($needMb && !function_exists('mb_str_split')) {
            $skipped++;
            echo "  SKIP  {$name} (需要 php-mbstring)\n";
            continue;
        }

        $actual = reverse_string($input);
        if ($actual === $expected) {
            $passed++;
            echo "  PASS  {$name}\n";
        } else {
            $failed++;
            echo "  FAIL  {$name} expected=" . var_export($expected, true)
                . " actual=" . var_export($actual, true) . "\n";
        }
    }

    echo 'total=' . count($cases) . " passed={$passed} failed={$failed} skipped={$skipped}\n";

    return $failed;
}

if (PHP_SAPI === 'cli' && isset($argv[0]) && realpath($argv[0]) === __FILE__) {
    echo 'reverse_string tests (PHP ' . PHP_VERSION . ")\n";
    exit(test_reverse_string() > 0 ? 1 : 0);
}
