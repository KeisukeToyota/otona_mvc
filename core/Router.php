<?php

class Router
{
    protected $routes;

    /**
     * コンストラクタ
     * @param array $definitions
     */
    public function __construct(array $definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }

    /**
     * ルーティング定義配列を内部用に変換する
     * @param array $definitions
     * @return array
     */
    public function compileRoutes(array $definitions): array
    {
        $routes = [];

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $i => $token) {
                if (strpos($token, ':') === 0) {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name . '>[^/]+)';
                }
                $tokens[$i] = $token;
            }

            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }

        return $routes;
    }

    /**
     * 指定されたPATH_INFOを元にルーティングパラメータを特定する
     * @param string $path_info
     * @return array|false
     */
    public function resolve(string $path_info)
    {
        if (substr($path_info, 0, 1) !== '/') {
            $path_info = '/' . $path_info;
        }

        foreach ($this->routes as $pattern => $params) {
            if (preg_match('#^' . $pattern . '$#', $path_info, $matches)) {
                $params = array_merge($params, $matches);
                return $params;
            }
        }

        return false;
    }
}