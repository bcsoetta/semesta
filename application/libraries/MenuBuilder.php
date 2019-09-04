<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MenuBuilder extends RecursiveIteratorIterator {
    protected $array;
    protected $output = '';

    public function __construct(array $array) {
        $this->array = new RecursiveArrayIterator($array);
        parent::__construct($this->array, parent::SELF_FIRST);
    }

    public function beginIteration() {
        $this->output .= "<li>";
    }

    public function endIteration() {
        $this->output .= "</li>";
    }

    public function beginChildren() {
        $this->output .= "<ul class='nav-sub'>";
    }

    public function endChildren() {
        $this->output .= "</ul></li>";
    }

    public function nextElement() {
        if (parent::callHasChildren()) {
            $this->output .= "<li><a><span class='nav-caret'><i class='fa fa-caret-down'></i></span><span class='nav-icon'><i class='material-icons'>&#xe8d2;</i></span><span class='nav-text'>".self::key()."</span></a>";
        } else {
            $this->output .= "<li><a href='". base_url() . self::current() ."'><span class='nav-text'>".self::key()."</span></a></li>";
        }
    }

    public function __toString() {
        $this->run();
        return $this->output;
    }

    protected function run() {
        self::beginIteration();
        while (self::valid()) {
            self::next();
        }
        self::endIteration();
    }
}