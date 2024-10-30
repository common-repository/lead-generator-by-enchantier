<?php

// usage [widget_lead_enchantier post_type="post" limit="9"].
function build_widget_enchantier($atts='', $content = null) {
    //récupère les paramètres
    $atts = shortcode_atts(
            array(
        'widget_type' => 'widget_devis', // maybe only one that will be used here
        'height' => '800', // in pixel
            ), $atts);
    //transforme les paramètres en variables
    extract($atts);

    $my_key = ENCHANTIER_KEY;
    $options = unserialize(get_option('ENCHANTIER_SETTINGS'));
    if (count($options) > 1) {
        $srv = $_SERVER['HTTP_HOST'];
        if(isset($options[$srv])){
            $my_key = $options[$srv];
        }
    }


    ob_start();
    switch ($widget_type) {
        case 'widget_full':
        default:
            ?>
            <script>var head = document.getElementsByTagName('head')[0]; var script = document.createElement('script'); script.type = 'text/javascript'; script.src = '//www.enchantier.com/module_widget/js/widget.js'; head.appendChild(script);</script>
            <iframe id='enchantier_iframe' scrolling='NO' style='border:none;' frameborder='0' src="//www.enchantier.com/widget/?AC=<?php echo $my_key ?>&mylot[]=true&mylot[]=true&mylot[]=true&mylot[]=true&mylot[]=true&mylot[]=true&mylot[]=true&mylot[]=true&save=true&noheader=<?php echo ENCHANTIER_NOHEADER ?>" width='800' height='<?= $height ?>px' style='border:none;'></iframe>            
            <?php
            break;
        case 'widget_devis':
            ?>
            <script>var head = document.getElementsByTagName('head')[0]; var script = document.createElement('script'); script.type = 'text/javascript'; script.src = '//www.enchantier.com/module_widget/js/widget-responsive-https.js'; head.appendChild(script);</script>
            <iframe id='enchantier_iframe' scrolling='NO' style='border:none;' frameborder='0' src="//www.enchantier.com/widget-responsive/?AC=<?php echo $my_key ?>&noheader=<?php echo ENCHANTIER_NOHEADER ?>" width="100%" height='<?= $height ?>px' style='border:none;'></iframe>
            <?php
            break;
    }

    return ob_get_clean();
}
