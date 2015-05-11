<?php
$config = Clementine::$config['module_bootstrap3datetimepicker'];
$this->getParentBlock($data, $request);
$input_types = array(
    'date'      => 'YYYY-MM-DD',
    'time'      => 'HH:mm',
    'datetime'  => 'YYYY-MM-DD HH:mm',
);
?>
<script>
jQuery(document).ready(function() {
<?php
foreach ($input_types as $type => $shadow_format) {
?>

    // input date time fallback
    jQuery('.clementine_crud-create_type-<?php echo $type; ?>, .clementine_crud-update_type-<?php echo $type; ?>').each(function() {
        // si pas de support natif, on remplace
        var shadow_el = jQuery('#' + jQuery(this).attr('id') + '-hidden');
        var shadow_format = '<?php echo $shadow_format; ?>';
        var datevalue = '';
        var datevalue_shadow_formatted = '';
        var shadow_el_val = shadow_el.val();
        if (shadow_el_val != '' && shadow_el_val != '0000-00-00' && shadow_el_val != '0000-00-00 00:00' && shadow_el_val != '0000-00-00 00:00:00') {
            datevalue = moment(shadow_el_val, shadow_format);
            datevalue_shadow_formatted = moment(datevalue).format(shadow_format);
        }
        if (<?php echo $config['force_crud_datepicker'] . ' || '; ?>jQuery(this).prop('type') == 'text') {
            jQuery(this).prop('type', 'text');
            jQuery(this).val('');
            jQuery(this).datetimepicker({
<?php
    if (isset($data['params_datepicker_' . $type])) {
        foreach ($data['params_datepicker_' . $type] as $param_key => $param_val) {
            echo $param_key . ': ' . $param_val . ',' . PHP_EOL;
        }
    }
?>
                defaultDate: datevalue
            });
            // desactive le handler actuel, on va le remplacer
            jQuery(this).off('change.<?php echo $data['class']; ?>_datepicker, focus.<?php echo $data['class']; ?>_datepicker, blur.<?php echo $data['class']; ?>_datepicker');
            jQuery(this).on('dp.change', function(e) {
                var el_id = e.target.id;
                var value = '';
                var moment = e.date;
                value = '';
                if (moment) {
                    value = moment.format(shadow_format);
                }
                //MAJ le champ shadow
                crud_js_datepicker_update_shadow(el_id, value);
            });
        } else {
            jQuery(this).val(datevalue_shadow_formatted);
        }
    });

<?php
}
?>
});
</script>
