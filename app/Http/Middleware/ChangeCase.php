<?php

namespace App\Http\Middleware;

use Closure;

use Symfony\Component\HttpFoundation\ParameterBag;

class ChangeCase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isJson()) {
            $this->changeParameters($request->json());
        }
        else {
            $this->changeParameters($request->request);
        }

        return $next($request);
    }

    private function changeParameters(ParameterBag $bag)
    {
        $bag->replace($this->changeCase($bag->all()));
    }

    private function changeCase(array $camelCases)
    {
        $snake_case = array();
        foreach ($camelCases as $camelCase=>$val) {
            preg_match_all(
                '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', 
                $camelCase, 
                $matches
            );
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) 
                         ? strtolower($match) 
                         : lcfirst($match);
            }
            $snake_case[implode('_', $ret)] = $val;
        }
        return collect($snake_case)->all();
    }
}
