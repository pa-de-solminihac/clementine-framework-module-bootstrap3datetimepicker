<?php
$cssjs = $this->getModel('cssjs');
$cssjs->register_css('bootstrap3datetimepicker', array(
    'src' => __WWW_ROOT_BOOTSTRAP3DATETIMEPICKER__ . '/skin/css/bootstrap-datetimepicker.min.css'
));
$cssjs->register_css('clementine-bootstrap3datetimepicker', array(
    'src' => __WWW_ROOT_BOOTSTRAP3DATETIMEPICKER__ . '/skin/css/clementine-bootstrap-datetimepicker.css'
));
$cssjs->register_foot('momentjs', array(
    'src' => __WWW_ROOT_MOMENTJS__ . '/skin/js/moment-with-locales.min.js'
));
$cssjs->register_foot('bootstrap3datetimepicker', array(
    'src' => __WWW_ROOT_BOOTSTRAP3DATETIMEPICKER__ . '/skin/js/bootstrap-datetimepicker.js'
));
$cssjs->register_foot('bootstrap3datetimepicker_js',
    $this->getBlockHtml('bootstrap3datetimepicker/js_datepicker', $data, $request)
);
$this->getParentBlock($data, $request);
