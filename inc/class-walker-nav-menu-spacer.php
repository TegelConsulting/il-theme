<?php
class Walker_Nav_Menu_Spacer extends Walker_Nav_Menu {
    private $last_item = false;

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($this->last_item) {
            $output .= '<li class="spacer"></li>';
        }
        parent::start_el($output, $item, $depth, $args, $id);
        $this->last_item = true;
    }

    function end_el(&$output, $item, $depth = 0, $args = array()) {
        parent::end_el($output, $item, $depth, $args);
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $output = rtrim($output, '<li class="spacer"></li>');
        parent::end_lvl($output, $depth, $args);
    }
}