<?php
class PaymentController extends BaseController{
    public function renderSignedData(){
        $view = View::make('signed');
        $view->title = 'Signed Data Fields';
        return $view;
    }

    public function renderUnsignedData(){
        $view = View::make('unsigned');
        $view->title = 'Unsigned Data Fields';
        $view->request = $_REQUEST;
        //s($_REQUEST);
        return $view;
    }
}
