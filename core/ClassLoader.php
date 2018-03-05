<?php

class ClassLoader
{
    protected $dirs;

    /**
     * 自身をオートロードスタックに登録
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * オートロード対象のディレクトリを登録
     * @param string $dir
     */
    public function registerDir(string $dir)
    {
        $this->dirs[] = $dir;
    }

    /**
     * クラスを読み込む
     * @param string $class
     */
    public function loadClass(string $class)
    {
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $class . '.php';
            if (is_readable($file)) {
                require_once $file;
                return;
            }
        }
    }
}