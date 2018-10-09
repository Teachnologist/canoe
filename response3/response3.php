<?php
/**by Jason Triche
 * Can be run on command line with php response3.php**/

class Mouth {

    public function helloAll(){
        echo "\nPATIENT: Hi, I'm here for an appointment\n";
    }

    public function byeAll(){
        echo "\nPATIENT: Have a great day to the Doctor, Receptionist and Public by way the Doctor's class!\n";
    }

    protected function helloDoc(){
        echo "\nPATIENT: Do whatever you need to Doc\n";
    }

    protected function open(){
        echo "\nPATIENT: HAAAAAAAA\n";
    }

    protected function close(){
        echo "\nPATIENT: HMMMMMMMMM\n";
    }

}

class Doctor extends Mouth{

    public function greet(){
        echo "\nDOCTOR: Hi, I'm your doctor and your protected methods can be used by me\n";
        $this->helloDoc();
    }

    public function openMouth(){
        echo "\nDOCTOR: Open your mouth\n";
        $this->open();
    }

    public function closeMouth(){
        echo "\nDOCTOR: Close your mouth\n";
        $this->close();
    }


}

class Receptionist {

    public function greet(){
        echo "\nRECEPTION: How can I help you? All interactions with the Doctor are PROTECTED\n";
    }

    public function listen(){
        $mouth = new Mouth();
        $mouth->helloAll();
    }

    public function assign(){
        echo "\nRECEPTION: We'll get you to a doctor\n";
    }

}

class OfficeController {

    public function run(){
        echo "Welcome to the PHP OOP  Office";
        $receptionist = new Receptionist();

        $receptionist->greet();
        sleep(1);
        $receptionist->listen();
        sleep(1);
        $receptionist->assign();
        sleep(2);

        $doctor = new Doctor();
        $doctor->greet();
        sleep(1);
        $doctor->openMouth();
        sleep(1);
        $doctor->closeMouth();
        $doctor->byeAll();


    }
}

$run = new OfficeController();

$run->run();
?>