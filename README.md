Completed by Jason Triche for Canoe Software on October 8, 2018

Q1. Given a SQL database with the following table full of data
CREATE TABLE countries (
code CHAR(2) NOT NULL,
year INT NOT NULL,
gdp_per_capita DECIMAL(10, 2) NOT NULL,
govt_debt DECIMAL(10, 2) NOT NULL
);

Please write the SQL statement to show the top 3 average government debts in percent of the
gdp_per_capita for those countries of which gdp_per_capita was over 40,000 dollars in every year in the
last four years.

SELECT `code`,AVG(`govt_debt`) AS `average_gov_debt`,
(SELECT SUM(`gdp_per_capita`) FROM `countries` WHERE `gdp_per_capita` > 40000 AND `year` >= YEAR(CURDATE()) - 4) AS `sum_of_all_over_40k`,
ROUND((AVG(`govt_debt`)/(SELECT SUM(`gdp_per_capita`) FROM `countries` WHERE `gdp_per_capita` > 40000 AND `year` >= YEAR(CURDATE()) - 4))*100,2) AS `percent_of_all_over_40k`
FROM `countries` WHERE `gdp_per_capita` > 40000 AND `year` >= YEAR(CURDATE()) - 4 GROUP BY `code` ORDER BY AVG(`govt_debt`) DESC LIMIT 3

Q2. What is CSRF? How is it different from XSS? How are these prevented?

CSFR and XSS seem similar on the surface. There are a few differences. CSFR stands for Cross Site Forgery Request. It forces the application to act on behalf of a user to submit a malicious request. CSFR attacks occur with state changing requests, meaning some sort of variable and/or value is acted upon, possibly interacting with database CRUD functions. The problem with this sort of attack is that a privileged user could have a method run that they did not intend to run, such as charging a credit card or updating credentials. In many CSFR attacks, the real user is logged in and the script executes as them.

XSS attacks are Cross Site Script attacks. In this case, malicious scripts can be injected to websites. Like CSFR, it may exploit cookies and other authentication data to act on behalf of a user.

Both attacks can be prevented by such measures as validating parameters from GET requests, stripping and escaping characters from form entries, and properly encoding data (html_encode, json_encode,url_encode,json serialization). In addition, developers should use discretion in using other people’s code. To prevent a CSFR attack from the developers prospective, we may include hash values and key/token with forms to insure that they are unique and served from the appropriate host; we may have the server check the header for the origin of the request and there values. Setting an expiration parameter for the token is also appropriate. A user should log off of a site before using the next site.

To prevent an XSS attack, a developer may want to include a javascript variable for a flag to make sure that the code comes from the application and is written for its intended purpose. A content security policy can be set up in the application and modifications to headers to insure that the scripts within the application are part of the application.

Q3. OOP general programming:
In real world, a man has a mouth. His mouth can do operations like open/close at the man's will. Another
man cannot force a man to do such operations without the man's permission. For example, a doctor can
examine his mouth and request him to do such operations and he will follow the doctor's requests after
confirming the doctor's identity. For others, he doesn't want them to do such operations. Use OOP Designs
to make needed classes with methods to meet those requirements. You can use any language or pseudocode
to write down your results.

Can be run on command line with "php response3.php"
<?php
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

Q4. What are the values of $a and $b after the following function calls and why?
class foo {
public $value = 6;
public function func1(&$value){
$return = $value;
$value += 1;
return $return;
}
public function &func2(){
return $this->value;
}
public function &func3(){
static $value = 8;
$value++;
return $value;
}
}
$obj = new foo;
$a = 2;
$b = $obj->func1($a);
What is the value of $a and why?
$a is equal to 3 because using & in the method's parameter passes a reference to to the original variable, in which the original variable is directly mutated.
$a = &$obj->func2();
What is the value of $a and why?
$a is equal to 6 because func2 is a getter for the value variable; so whatever value is set at at the time this is called will be returned. There is no setter, so the & in front of the function makes the variable a reference
$obj->value = 5;
What is the value of $a and why?
In the previous command, $a became a reference for $obj->value. When $obj->value is set to something else, and $a remains, $a assumes the value of $obj->value
$a = &$obj->func3();
What is the value of $a and why?
The method returns a value. Inside the method, $value becomes static, is reinstantiated, incremented and returned
$obj->value = 7;
What is the value of $a and why?
Even though a function reference has been created, func3 still instantiates value and returns a value.

Q5. Please complete jQuery and PHP code to prepare the inputs for model updating.
In a form, we have three input boxes for users to type in their choices of courses and submit the form
without refreshing the page(i.e using ajax request). Here are the requirements:
1. User can type in 1, 2 or 3 courses
2. Each choice is case insensitive (also, user can type anything, in any case or leave it empty)
3. The choices have to contain “calculus”(in any case, e.g “Calculus” or “CALCULUS”) in one input
box.
4. Because form onsubmit returns false, the form is submitted through ajax by calling submitForm(),
add your Javascript/jQuery code inside of this function.
5. The PHP on the server side needs to do the same validation as in Javascript/jQuery to make sure
data is consistent.

This is easier to read in the response5 directory.

<html>
<head>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
 ></script>
    <style>
        .success{
            color:green;
        }
        .error{
            color:red;
        }
    </style>
</head>

<body>


<form action="./api/post.php" onsubmit="submitForm();return false;">
    Choice A: <input type="text" name="choices[]"/>
    Choice B: <input type="text" name="choices[]"/>
    Choice C: <input type="text" name="choices[]"/>
    <input type="submit" value="Submit"/>
</form>
<p id="warning"></p>
</body>
<script type="text/javascript">
$(document).ready(function(){
    var REQUIRED_WORD = "calculus";
    $("form").removeAttr("onsubmit");
    $("form").on('submit',function(e){
        e.preventDefault();
        submitForm();
    });


    function submitForm() {
        var $form = $('form');
        var url = $('form').attr('action');
       // $form.removeAttr("action");
        validateInputs(url,$form);
        return false;
    }

    function runAjax(url,$form){
        $.ajax({
            type: "POST",
            url: url,
            data: $form.serialize(), // serializes the form's elements.
            success: function (data) {
                var json = JSON.parse(data); // show response from the php script.
                $("#warning").html(json.insert_log.status+"</br>");
                $("#warning").append(json.message+"</br>");
                $("#warning").append(json.controller_class+"</br>");
                $("#warning").removeClass();
                $("#warning").addClass("success");
            }
        });

    }

    function validateInputs(url,$form){
        var array = $form.children("input[name='choices[]']");
        var truthy = false;
        if(typeof array == "undefined" || typeof array != "object" || !array){
            $("#warning").html("Input invalid. Be sure to add Calculus");
            $("#warning").removeClass();
            $("#warning").addClass("error");
        }

        array.each(function(index,value){
            if(value.value.toLowerCase() == REQUIRED_WORD.toLowerCase()){
                truthy = true;
                runAjax(url,$form);

            }


            if(index == array.length - 1 && !truthy){
                $("#warning").html("Input invalid. Should not reach this statement.");
                $("#warning").removeClass();
                $("#warning").addClass("error");
            }
        });
    }




});
</script>

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jason
 * Date: 10/9/18
 * Time: 12:06 AM
 */

class Controller
{
public function why(){
    return "It comes with the Controller class, very likely a laravel Class to query the database";
}
}
?>

<?php
include('../Controllers/MyController.php');
$inputs = new MyController();
$inputs->setKeyword("calculus");

$log = array();
$log["insert_log"] = NULL;


if($inputs->validate($_POST["choices"])){
    $log["insert_log"] = $inputs->post();
}


$log["message"] = $inputs->getMessage();
$log["controller_class"] = $inputs->why();

echo json_encode($log);
?>

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






