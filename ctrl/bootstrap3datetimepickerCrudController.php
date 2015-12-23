<?php
class bootstrap3datetimepickerCrudController extends bootstrap3datetimepickerCrudController_Parent
{
    public function override_fields_create_or_update($request, $params = null)
    {
        $ret = parent::override_fields_create_or_update($request, $params);
        $this->data['params_datepicker_date'] = array(
            'locale' => "'fr'",
            'useCurrent' => 'false',
            'extraFormats' => "['YYYY-MM-DD', 'DD/MM/YYYY']",
            'format' => "'DD/MM/YYYY'",
        );
        $this->data['params_datepicker_time'] = array(
            'locale' => "'fr'",
            'useCurrent' => 'false',
            'format' => "'HH:mm'",
        );
        $this->data['params_datepicker_datetime'] = array(
            'locale' => "'fr'",
            'useCurrent' => 'false',
            'extraFormats' => "['YYYY-MM-DD HH:mm', 'DD/MM/YYYY HH:mm']",
            'format' => "'DD/MM/YYYY HH:mm'",
        );
        return $ret;
    }

    public function register_ui_scripts($mode = 'index', $params = null)
    {
        $ret = parent::register_ui_scripts($mode, $params);
        $cssjs = Clementine::getModel('cssjs');
        if (in_array($mode, array('create', 'update'))) {
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
        }
        return $ret;
    }

}
