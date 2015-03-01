<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 24.02.15
 * Time: 19:08
 */

include_once(MODEL_DIR."SymptByPatient_Model.class.php");

class SymptByPatient_Controller {
    public $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function invoke()
    {
        if (!isset($_GET['book']))
        {
            // no special book is requested, we'll show a list of all available books
            $books = $this->model->getBookList();
            include 'view/booklist.php';
        }
        else
        {
            // show the requested book
            $book = $this->model->getBook($_GET['book']);
            include 'view/viewbook.php';
        }
    }


}