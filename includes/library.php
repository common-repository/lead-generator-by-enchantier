<?php

class json_enchantier {

    public $formulaires, $formulaires_structured;
    private $filename;

    public function __construct($filename = 'enchantier_setup.json') {
        $this->filename = ABSPATH . $filename;
        if (!file_exists($this->filename)) {
            copy(WP_PLUGIN_DIR . '/lead-generator-by-enchantier/ini/' . $filename, $this->filename);
        }

        $this->load_formulaires($this->filename);
        return JSON_ERROR_NONE === json_last_error();
    }

    private function load_formulaires($fichier) {
        $this->formulaires = json_decode(file_get_contents($fichier));
        if(!file_exists($fichier)){
            retrurn ('fichier ini introuvable !');
        }
        $this->update_formulaires_structured();
    }
    private function update_formulaires_structured() {        
        foreach ($this->formulaires as $formulaire) {
            list($group, $name) = explode('|', $formulaire->form_name);
            $this->formulaires_structured[trim($group)][trim($name)] = array('form_id' => $formulaire->form_id, 'URLs' => $formulaire->URLs);
        }        
    }
    public function list_html($name = "formulaire", $url = '') {
        $this->order_by('name');
        $html = "<select id='$name' name='$name' class='form_list'><option value=''>Par défaut (Accueil du widget)</option>";
        foreach ($this->formulaires_structured as $group => $content) {
            $html.= "<optgroup label='$group'>";
            foreach ($content as $nom => $values) {
                if (in_array($url, $values['URLs'])) {
                    $html.="<option value='{$values['form_id']}' selected='selected'>" . $nom . " <sup>({$values['form_id']})</sup></option>";
                } else {
                    $html.="<option value='{$values['form_id']}'>" . $nom . " <sup>({$values['form_id']})</sup></option>";
                }
            }
            $html.= "</optgroup>";
        }
        return $html . "</select>";
    }

    public function order_by($ordre = 'id') {
        // apply sort function from INSIDE class
        usort($this->formulaires, array($this, 'compare_' . $ordre));
    }

    private function compare_id($a, $b) {
        return strnatcmp($a->form_id, $b->form_id);
    }

    private function compare_name($a, $b) {
        return strnatcmp($a->form_name, $b->form_name);
    }

    public function clear_form() {
        foreach ($this->formulaires as &$formulaire) {
            $formulaire->URLs = array();
        }
    }

    public function add_form($form, $url) {
        foreach ($this->formulaires as &$formulaire) {
            if ($formulaire->form_id == $form) {
                $formulaire->URLs[] = $url;
            }
        }
    }

    public function save_form() {
        $fp = fopen($this->filename, 'w');
        fwrite($fp, json_encode($this->formulaires));
        fclose($fp);
        $this->update_formulaires_structured();
    }

}
