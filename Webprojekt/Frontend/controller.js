function loadList(){
    $("li").remove();
    $.ajax({
        type: "GET",
        url: "../Backend/serviceHandler.php",
        cache: false,
        data: {method: "load", param: "load"},
        dataType: "json",
        success: function (response){
            console.log("success loading list. the list:");
            console.log(response);
            response.forEach(appointment =>{
                let e = appointment.name;
                $("ol").append("<li>" + e + "</li>");
                }
            );
        },
        error: function (response){
            console.log("error");
            console.log(response);
        }
    })
}

function addItem(){
    //visibilities
    $('#appointmentList').slideUp(500, function () {
        $('#newAppointment').fadeIn(200);
    });
    $('#cancel').on('click', function (){
        $('#newAppointment').slideUp(500, function () {
            $('#appointmentList').fadeIn(200);
        });
    });

    //more options button
    let options = 1;
    $('#moreOptions').on('click', function (){
        options += 1;
        let option = "<input type=\"datetime-local\" id=\"" + options + "\" name=\"" + options + "\" class=\"form-control\">\n"
        $('#start').append(option);

        options += 1;
        option = "<input type=\"datetime-local\" id=\"" + options + "\" name=\"" + options + "\" class=\"form-control\">\n"
        $('#end').append(option);
    });

    $('#submit').on('click', function (){
        $('#appointmentForm').validate({
            rules: {0: {required: true, date: true}, 1: {required: true, date: true}}, //checks that at least one start and end date are submitted
            //we should write our own rule so that start is always earlier than end TODO
            submitHandler: submit,
        });
    });


}

function submit(){
    console.log("submitted");
    var dateOptions = [$('#0').val(), $('#1').val()];

    //i don't know why it won't take additional options.. TODO
    var i = 2;
    var j = 3;
    while($('#i').length > 0) {
        ++i;
        ++j;
        let additionalOption = [$('#i').val, $('#j').val]
        dateOptions.concat(additionalOption);
        console.log(dateOptions);
    }

    var payload = {
        name : $('#name').val(),
        description : $('#description').val(),
        creator : $('#creator').val(),
        method: "newAppointment",
        param: "newAppointment"
    };
    console.log(payload);

    $.ajax({
        type: "POST",
        method: "POST",
        url: "../Backend/serviceHandler.php",
        data: payload,
        cache: false,
        dataType: "json",
        success: function (response) {
            console.log("ajax post success. response:")
            console.log(response);
        },
        error: function(response){
            console.log("ajax post error. response:")
            console.log(response);
            let errormessage = "<p>" + response['status'] + " " + response['responseText'] + "</p>";
            alert(errormessage);
        }
    });
}

function toggleList(){ /*toggle between hide and show*/
    $('ol').toggle();
    if($('ol').is(":visible")){
        $("#visibility").text("hide");
    }
    else{
        $("#visibility").text("show");
    }
}

function editList(){
    $("li").prepend("<button class=\"remove btn btn-outline-danger\">remove</button> "); /*add remove button for each item*/
    $(".remove").click(function (){
        $(this).closest("li").remove(); /*remove closest list item if clicked*/
    });
    $("#edit").text("quit editing");
    $("#edit").on("click.myModule", function () { /*second click event is to remove remove buttons and remove exactly this click event, so on next click, we go into edit*/
        $(".remove").remove();
        $("#edit").text("edit");
        $("#edit").off("click.myModule");
    });
}

$(document).ready(function () { /*sortable in jquery ui library, hide placeholders so the numbering doesn't change during drag and drop*/
    $('ol').sortable({
        start: function( event, ui ){
            $(ui.item).parent().find('.ui-sortable-placeholder').hide();
        },
    });
});

$(document).ready(
    $("#add").on("click", addItem),
    $('#visibility').on("click", toggleList),
    $('#edit').on("click", editList),
    $('#newAppointment').hide(),
    loadList()
);
