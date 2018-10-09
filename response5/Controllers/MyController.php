<?php

include('Controller.php');

class MyController extends Controller {

    private $inputs = array();
    private $keyword = NULL;
    private $message = NULL;


    public function setKeyword($keyword){
        $this->keyword = $keyword;
    }

    public function getKeyword(){
        return $this->keyword;
    }

    private function destroyInputs(){
        $this->inputs = [];
    }

    private function setInputs($input){
        $this->inputs[] = $input;
    }

    public function getInputs(){
        return $this->inputs;
    }

    private function setMessage($message){
        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }



    public function validate($array){
        $valid = false;
        $keyword = strtolower($this->getKeyword());
        foreach($array  AS $arr){
            $this->setInputs($arr);

            if(strtolower($arr) === $keyword){
                $valid = true;
            }

        }

        if(!$valid){
            $this->destroyInputs();
            $this->setMessage("Choices are invalid. User did not type ".$this->getKeyword());
            return false;
        }else{
            $this->setMessage("The following words can be inserted ".implode(",",$this->getInputs()));
            return true;
        }
    }

    public function post() {
        /*this seems like a Laravel class rather than straightforward php or adodb*/
        $inputs = $this->getInputs();
//add your code after this line
//end of add your code
        //ADDED AS PUBLIC METHOD
        if($this->save($inputs)) {
            return [ 'status'=>'success' ];
        } else {
            return ['status'=>'error', 'errorMessage' => $this->getLastErrorMessage()];
        }
    }

    private function save($array){
        //placeholder for save routine
        if(count($array) > 0){
            $this->setMessage("The following words were inserted ".implode(",",$this->getInputs()));
            return true;
        }else{
            $this->setMessage("Entries could not be inserted");
            return false;

        }

    }
    

}

?>