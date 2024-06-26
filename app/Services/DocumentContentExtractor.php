<?php

namespace App\Services;

/**
 * Created by IntelliJ IDEA.
 * User: bill
 * Date: 2018/11/06
 * Time: 13:24
 */

use InvalidArgumentException;


class DocumentContentExtractor
{
    private $extension;
    private $filePath;

    public function __construct($filePath, $extension = null)
    {
        if ($extension === null) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        }

        if (!in_array($extension, ['docx', 'doc', 'rtf', 'txt',])) {
            throw new InvalidArgumentException();
        }

        $this->extension = $extension;
        $this->filePath = $filePath;
    }

    /**
     * 注意，初始值需要为false
     *
     * 获取值，缓存到对象内部，在运行期不再重新获取
     * @param mixed $var 缓存到哪一个变量中
     * @param string $retriever 通过哪个函数来获取将被缓存的变量
     * @param null $emptyValue 默认值是什么
     * @param bool $disableCache
     * @param bool $initialValue 传入的值为怎样的值可以看做还未运行过获取数据的方法
     * @return null
     */
    public static function getCachedProperty(&$var, $retriever, $emptyValue = null, $disableCache = false, $initialValue = false)
    {
        if ($var !== $initialValue && $disableCache === false) {
            return $var;
        }
        if (is_callable($retriever)) {
            $var = $retriever();
        } else {
            $var = $retriever;
        }

        if ($var === $initialValue || $var === null) {
            if (is_callable($emptyValue)) {
                $var = $emptyValue();
            } else {
                $var = $emptyValue;
            }
        }

        return $var;
    }

    private $content = false;

    public function getContent()
    {
        if (!file_exists($this->filePath)) {
            return null;
        }

        return $this->getCachedProperty($this->content, function () {
            switch ($this->extension) {
                case 'doc':
                    exec(sprintf("antiword %s", escapeshellarg($this->filePath)), $output, $exitCode);
                    return implode("\n", $output);
                case 'docx':
                    exec(sprintf("docx2txt %s -", escapeshellarg($this->filePath)), $output, $exitCode);
                    return implode("\n", $output);
                case 'rtf':
                    exec(sprintf("unrtf --html %s", escapeshellarg($this->filePath)), $output, $exitCode);

                    return strip_tags(html_entity_decode(implode("\n", $output)));
                case 'txt':
                    return file_get_contents($this->filePath);
                default:
                    return null;
            }
        });

    }

}
