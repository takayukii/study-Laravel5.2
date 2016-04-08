<?php
function delete_form($namedRoute, $label = '削除')
{
    $form = Form::open(['method' => 'DELETE', 'route' => $namedRoute]);
    $form .= Form::submit($label, ['class' => 'btn btn-danger']);
    $form .= Form::close();

    return $form;
}
