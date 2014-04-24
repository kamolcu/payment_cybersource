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
        Log::info('-=-Thank you page-=-');
        $logString = print_r($_REQUEST, true);
        Log::info($logString);
        $view = View::make('thankyou');
        $view->title = 'Thank you';
        s($_REQUEST);
        return $view;
    }

    public function renderBackground(){
        Log::info('-=-Background-=-');
        $logString = print_r($_REQUEST, true);
        Log::info($logString);
        $view = View::make('background');
        $view->title = 'background';
        return $view;
    }
}
