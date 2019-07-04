<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once dirname(__FILE__) . '/fpdf/fpdf.php';
require_once dirname(__FILE__) . '/fpdi/fpdi.php';

class Pdf extends FPDF {
    function __construct() {
        parent::__construct();
    }

}
