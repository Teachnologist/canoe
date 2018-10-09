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

</html>