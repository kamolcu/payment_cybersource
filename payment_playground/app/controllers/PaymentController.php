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

    public function renderThankyou(){
        s($_REQUEST);
        $view = View::make('thankyou');
        $view->title = 'Thank you';
        return $view;
    }

    public function renderBackground(){
        $logString = print_r($_REQUEST, true);
        Log::info($logString);
        $view = View::make('background');
        $view->title = 'background';
        return $view;
    }
}
