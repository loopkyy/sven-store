<?php

function get_setting($key)
{
    $model = new \App\Models\SettingModel();
    $row = $model->where('key_name', $key)->first();
    return $row ? $row['value'] : null;
}
