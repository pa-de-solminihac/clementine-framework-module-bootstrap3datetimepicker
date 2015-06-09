<?php
$config = Clementine::$config['module_bootstrap3datetimepicker'];
$input_types = array(
    'text'      => array(
        'shadow' => 'YYYY-MM-DD HH:mm',
        'fr' => 'DD/MM/YYYY HH:mm',
    ),
    'date'      => array(
        'shadow' => 'YYYY-MM-DD',
        'fr' => 'DD/MM/YYYY',
    ),
    'time'      => array(
        'shadow' => 'HH:mm',
        'fr' => 'HH:mm',
    ),
    'datetime'  => array(
        'shadow' => 'YYYY-MM-DD HH:mm',
        'fr' => 'DD/MM/YYYY HH:mm',
    ),
);
?>
<script>
function bootstrap3datetimepicker_update_shadow(id, value) {
    // TODO: ici, convertir le format de date, peut être en utilisant moment.js ? auquel cas il faudra en faire un module indépendant...
    // TODO: vérifier que la validation HTML5 en AJAX passe toujours bien
    var shadow_el = jQuery('#' + id + '-hidden');
    if (value == null) {
        value = '';
    }
    shadow_el.val(value);
    return true;
}
jQuery(document).ready(function() {
    jQuery('.bootstrap3datetimepicker').on(
        'change.bootstrap3datetimepicker_datepicker, focus.bootstrap3datetimepicker_datepicker, blur.bootstrap3datetimepicker_datepicker',
        function(e) {
            var el = jQuery(this);
            var el_id = el.attr('id');
            var selected_value = el.val();
            bootstrap3datetimepicker_update_shadow(el_id, selected_value);
        }
    );
<?php
foreach ($input_types as $type => $shadow_format) {
?>
    // input date time fallback
    jQuery('input[type=<?php echo $type; ?>].bootstrap3datetimepicker').each(function() {
        var el= jQuery(this);
        var el_id = el.attr('id');
        var datevalue = '';
        var datevalue_shadow_formatted = '';
        var shadow_format = '<?php echo $shadow_format['shadow']; ?>';
        var l10n_format = '<?php
    if (!empty($shadow_format['fr'])) {
        echo $shadow_format['fr'];
    } else {
        echo $shadow_format['shadow'];
    }
?>';
        var shadow_el = jQuery('#' + el_id + '-hidden');
        // crée l'élément shadow s'il n'existe pas
        if (!shadow_el.length) {
            el.after('<input type="hidden" id="' + el_id + '-hidden'+ '" name="' + el.attr('name') + '" value="" />');
            el.removeAttr('name');
            shadow_el = jQuery('#' + el_id + '-hidden');
            var el_val = el.val();
            if (el_val) {
                //bootstrap3datetimepicker_update_shadow(el_id, moment(el_val, shadow_format).format(shadow_format));
                bootstrap3datetimepicker_update_shadow(el_id, el_val);
            }
        }
        var shadow_el_val = shadow_el.val();
        if (shadow_el_val != '' && shadow_el_val != '0000-00-00' && shadow_el_val != '0000-00-00 00:00' && shadow_el_val != '0000-00-00 00:00:00') {
            datevalue = moment(shadow_el_val, shadow_format);
            datevalue_shadow_formatted = moment(datevalue).format(shadow_format);
        }
        // si pas de support natif, on remplace
        if (<?php echo $config['force_bootstrap3datetimepicker'] . ' || '; ?> el.prop('type') == 'text') {
            el.prop('type', 'text');
            el.val(moment(datevalue).format(l10n_format));
            el.datetimepicker({
<?php
    if (!empty($data['params_datepicker_' . $type])) {
        foreach ($data['params_datepicker_' . $type] as $param_key => $param_val) {
            echo $param_key . ': ' . $param_val . ',' . PHP_EOL;
        }
    }
?>
                locale: 'fr',
                useCurrent: false,
                format: l10n_format,
                defaultDate: datevalue
            });
            // desactive le handler actuel, on va le remplacer
            el.off('change.bootstrap3datetimepicker_datepicker, focus.bootstrap3datetimepicker_datepicker, blur.bootstrap3datetimepicker_datepicker');
            el.on('dp.change', function(e) {
                var el_id = e.target.id;
                var value = '';
                var moment = e.date;
                value = '';
                if (moment) {
                    value = moment.format(shadow_format);
                }
                //MAJ le champ shadow
                bootstrap3datetimepicker_update_shadow(el_id, value);
            });
        } else {
            el.val(datevalue_shadow_formatted);
        }
    });
<?php
}
?>
});
</script>
