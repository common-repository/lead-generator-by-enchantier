<?php

new EnChantier();

class EnChantier {

    public $options;

    public function __construct() {
        include_once(ABSPATH . '/wp-admin/includes/file.php');
        if (isset($_POST['ENCHANTIER_KEY']) && $_POST['ENCHANTIER_KEY'] != '') {
            update_option('ENCHANTIER_KEY', sanitize_key($_POST['ENCHANTIER_KEY']));
            update_option('ENCHANTIER_PASSWORD', md5($_POST['mdp']));
        }
        if (isset($_POST['noheader']) && $_POST['noheader'] != '') {
            update_option('ENCHANTIER_NOHEADER', ($_POST['noheader'] == "true") ? 'true' : 'false');
        }
        $this->api_key = get_option('ENCHANTIER_KEY'); // load settings
        $this->mdp = get_option('ENCHANTIER_PASSWORD');
        $this->options = unserialize(get_option('ENCHANTIER_SETTINGS'));
        define('ENCHANTIER_KEY', $this->api_key);
        define('ENCHANTIER_PASSWORD', $this->mdp);
        define('ENCHANTIER_NOHEADER', get_option('ENCHANTIER_NOHEADER'));

        add_action('admin_menu', array($this, 'add_admin_menu'), 20); // build menus
        if ($this->is_installed()) {
            add_shortcode('widget_lead_enchantier', 'build_widget_enchantier');
            add_action('widgets_init', 'register_foo_widget');
        } else {
            // envoyer un message à l admin
            add_action('admin_notices', 'EnChantier_admin_notice');
            add_action('admin_init', 'EnChantier_nag_ignore');
        }
    }

    public function add_admin_menu() {
        if (!$this->is_installed()) {
            add_menu_page(__('Bienvenue dans Enchantier'), __('Générer Leads'), 'manage_options', 'EnChantier', array($this, 'register'), 'dashicons-warning');
            add_submenu_page('EnChantier', __('S\'inscrire'), __('S\'inscrire'), 'manage_options', 'EnChantier', array($this, 'register'));
        } else {
            add_menu_page(__('Bienvenue dans EnChantier'), __('Générer Leads'), 'manage_options', 'EnChantier', array($this, 'menu_home'), 'dashicons-awards');
            add_submenu_page('EnChantier', __('Activité / Facturation'), __('Activité / Facturation'), 'manage_options', 'EnChantier', array($this, 'menu_home'));
            add_submenu_page('EnChantier', __('Afficher mes Widget'), __('Afficher mes Widget'), 'manage_options', 'code_EnChantier', array($this, 'menu_code'));
            add_submenu_page('EnChantier', __('Réglages fins'), __('Réglages fins'), 'manage_options', 'setup_EnChantier', array($this, 'menu_setup'));
            add_submenu_page('EnChantier', __('Gérer mes clés/URL'), __('Gérer mes clés/URL'), 'manage_options', 'manage_EnChantier', array($this, 'menu_url'));
        }
        add_submenu_page('EnChantier', __('FAQ'), __('FAQ'), 'manage_options', 'faq_EnChantier', array($this, 'menu_faq'));
        add_submenu_page('EnChantier', __('Lisez moi'), __('Lisez moi'), 'manage_options', 'readme_EnChantier', array($this, 'menu_readme'));
        add_submenu_page('EnChantier', __('Contact EnChantier'), __('Contact EnChantier'), 'manage_options', 'about_EnChantier', array($this, 'menu_about'));
        add_submenu_page(null, __('CGU'), __('CGU'), 'manage_options', 'CGU_EnChantier', array($this, 'menu_CGU'));
    }

    public function menu_home() {
        global $current_user;
        get_currentuserinfo();
        $urls = array(
            __('Activité / Facturation') => 'https://www.enchantier.com/module_partenaire/?api_key=' . ENCHANTIER_KEY . '&hash=' . ENCHANTIER_PASSWORD . '&name=' . $current_user->display_name
        );
        $url = $urls[get_admin_page_title()];
        echo '<iframe id="EnChantierFrame" style="min-height: 600px;width: 101.35%;margin-left:-20px;" src="' . $url . '"></iframe>';
        $this->fix_iframe_height();
    }

    public function menu_setup() {
        include CD_PLUGIN_PATH . "includes/setup_form.php";
    }

    public function menu_about() {
        # Read file and pass content through the Markdown parser
        $text = file_get_contents(CD_PLUGIN_PATH . 'ABOUT.md');
        echo markdown($text);
    }

    public function menu_readme() {
        # Read file and pass content through the Markdown parser
        $text = file_get_contents(CD_PLUGIN_PATH . 'readme.txt');
        echo markdown($text);
    }

    public function menu_faq() {
        # Read file and pass content through the Markdown parser
        $text = file_get_contents(CD_PLUGIN_PATH . 'FAQ.md');
        echo markdown($text);
    }

    public function menu_code() {
        # Read file and pass content through the Markdown parser
        $text = file_get_contents(CD_PLUGIN_PATH . 'HOW_TO.md');
        echo markdown($text);
    }

    public function menu_CGU() {
        # Read file and pass content through the Markdown parser
        $text = file_get_contents(CD_PLUGIN_PATH . 'CONDITIONS.md');
        echo markdown($text);
    }

    public function menu_url() {
        include CD_PLUGIN_PATH . "includes/key_form.php";
    }

    public function register() {
        include CD_PLUGIN_PATH . "includes/register_form.php";
    }

    public function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function fix_iframe_height() {
        ?>
        <script type="text/javascript">
            jQuery(function ($) {
                $('#EnChantierFrame').height($('#wpwrap').height());
                $(window).unload(function () {
                    $.ajax({
                        crossDomain: true,
                        dataType: 'jsonp',
                        jsonp: false,
                        type: "GET",
                        url: "https://www.enchantier.com/module_partenaire/index.php",
                        async: false,
                        data: "c=3",
                        success: function (msg) {
                            console.log(msg);
                        }
                    });
                });
            });
        </script><?php

    }

    public function is_installed() {
        return $this->api_key !== FALSE && $this->api_key !== '';
    }

    public function save_options() {
        update_option('ENCHANTIER_SETTINGS', serialize($this->options));
    }

}
