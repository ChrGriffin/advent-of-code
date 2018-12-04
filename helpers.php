<?php

function loadFile($path, $cast = null)
{
    return array_filter(array_map(
        function ($value) use ($cast) {
            if($cast !== null) {
                settype($value, $cast);
            }

            return $value;
        },
        explode("\n", file_get_contents($path))
    ));
}
