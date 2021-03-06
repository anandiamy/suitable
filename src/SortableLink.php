<?php

namespace Laravolt\Suitable;

class SortableLink
{
    protected static $classMapping = [
        'asc'  => [
            'header' => 'ascending sorted',
            'icon'   => 'caret up',
        ],
        'desc' => [
            'header' => 'descending sorted',
            'icon'   => 'caret down',
        ],
    ];

    public static function make($parameters)
    {
        $sortByKey = config('suitable.query_string.sort_by');
        $sortDirectionKey = config('suitable.query_string.sort_direction');

        if (count($parameters) == 1) {
            $parameters[1] = ucfirst($parameters[0]);
        }

        $column = $parameters[0];
        $title = $parameters[1];

        $headerClass = '';
        $iconClass = 'sort';
        if (request($sortByKey) == $column && in_array(request($sortDirectionKey), ['asc', 'desc'])) {
            $headerClass = self::$classMapping[request($sortDirectionKey)]['header'];
            $iconClass = self::$classMapping[request($sortDirectionKey)]['icon'];
        }

        $icon = sprintf('<i class="icon %s"></i>', $iconClass);

        $sortableQueryString = [
            $sortByKey        => $column,
            $sortDirectionKey => request($sortDirectionKey) === 'asc' ? 'desc' : 'asc',
        ];

        $queryString = array_merge(request()->input(), $sortableQueryString);

        $url = request()->url().'?'.http_build_query($queryString);

        return '<th class="'.$headerClass.'"><a href="'.$url.'"'.'>'.htmlentities($title).' '.$icon.'</a></th>';
    }
}
