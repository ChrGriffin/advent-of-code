<?php

function loadFile($path, Closure $callback = null)
{
    return array_map(
        function ($value) use ($callback) {

            if($callback !== null) {
                return $callback($value);
            }

            return $value;
        },
        array_filter(
            explode("\n", file_get_contents($path))
        )
    );
}
