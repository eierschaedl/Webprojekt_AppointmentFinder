function loadList(){
    $("li").remove();
    $.ajax({
        type: "GET",
        url: "../Backend/serviceHandler.php",
        cache: false,
        data: {method: "load", param: "load"},
        dataType: "json",
        success: function (response){
            console.log("success");
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
    $('#moreOptions').on('click', function(){
        options += 1;
        let option = "<input type=\"datetime-local\" id=\"" + options + "\" class=\"form-control\">\n"
        $('#start').append(option);
        console.log(option);

        options += 1;
        option = "<input type=\"datetime-local\" id=\"" + options + "\" class=\"form-control\">\n"
        $('#end').append(option);
    });

    //submit -> ajax call
    $('#submit').on('click', function (){
        //check if input ok
        //checkout jquery validate()
        //ajax post to db
        }
    );
}

function toggleList(){ /*toggle between hide and show*/
    $("ol").toggle();
    if($("ol").is(":visible")){
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
