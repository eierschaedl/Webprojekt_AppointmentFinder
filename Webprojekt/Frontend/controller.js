function loadList(){
    $("ol").empty();
    $.ajax({
        type: "GET",
        url: "../Backend/serviceHandler.php",
        cache: false,
        data: {method: "load", param: "overview"},
        dataType: "json",
        success: function (response){
            console.log("success loading list. the list:");
            console.log(response);
            response.forEach(appointment =>{
                let name = appointment.name;
                let id = "id=\"appointment-" + appointment.id + "\"";
                let category = "class=\"active\"";
                if (appointment.active == 0){
                    category = "class=\"inactive\"";
                }
                let creator = "erstellt von: " + appointment.creator;
                let description = "Beschreibung: " + appointment.description.substring(0, 100) + "...";
                //$("ol").append("<li " + category + ">" + name + "</li>");
                $("ol").append("<li " + category + id +"><div class=\"card\"><div class=\"card-header\">" + name + "</div><div class=\"class-body\">" + creator + "<br>" + description + "</div></div></li>");
                }
            );
            $('li').on("click", details);
        },
        error: function (response){
            console.log("error");
            console.log(response);
        }
    })
}

function details(){
    //hide list list and show details section
    $('#appointmentList').slideUp(500, function () {
        $('#details').fadeIn(200);
    });
    //create click event for back button to go back to list section
    $('#back').on('click', function (){
        $('#details').slideUp(500, function () {
            $('#appointmentList').fadeIn(200);
        });
    });
    //get id to read details from database
    let appointment = $(this);
    let id = appointment.attr('id');
    id = id.match(/\d+/);
    id = id[0];
    //console.log(id);
    $.ajax({
        type: "GET",
        url: "../Backend/serviceHandler.php",
        cache: false,
        data: {method: "load", param: "details", id: id},
        dataType: "json",
        success: function (response){
            $('tr').detach();
            //[0] is the appointment, everything following are dateoptions
            //so extract appointment info...
            $('#detail-name').text(response[0]['name']);
            $('#detail-creator').text("erstellt von " + response[0]['creator']);
            $('#detail-description').text(response[0]['description']);
            let tr = "";
            let active = 0;
            if(response[0]['active'] == 1){
                tr = "<tr><th>Terminoption</th><th>Stimmen für diese Option</th><th>Auswahl</th>"
                active = 1;
            }
            else{
                tr = "<tr><th>Terminoption</th><th>Stimmen für diese Option</th><th>keine Auswahl mehr möglich</th>";
                active = 0;
            }

            //and then remove, so we are left with just dateoptions.
            response.shift();
            $('#thead').append(tr);
            response.forEach(dateoption =>{
                let start = dateoption.start;
                let end = dateoption.end;
                let votes = dateoption.votes;
                if(active) {
                    let choice = "<input type=\"checkbox\" id=\"option-" + dateoption.id + "\" name=\"choice\" value=\"" + dateoption.id + "\">";
                    tr = "<tr><td>" + start + " - " + end + "</td><td>" + votes + "</td><td>" + choice + "</td>"
                }
                else {
                    tr = "<tr><td>" + start + " - " + end + "</td><td>" + votes + "</td>"
                }
                $('#tbody').append(tr);
                }
            );
            $('#submitChoice').on('click', function (){
                $('#choiceForm').validate({
                    submitHandler: submitPerson(),
                });
            });
        },
        error: function (response){
            console.log("error");
            let errormessage = "<p>" + response['status'] + " " + response['responseText'] + "</p>";
            alert(errormessage);
        }
    })
}

var options;

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

    //one starting and ending is required...
    $('#start').empty();
    let start = "<input type=\"datetime-local\" id=\"0\" name=\"0\" required class=\"form-control\">\n"
    $('#start').append(start);

    $('#end').empty();
    let end = "<input type=\"datetime-local\" id=\"1\" name=\"1\" required class=\"form-control\">\n"
    $('#end').append(end);

    //...more are optional
    options = 1;
    $('#moreOptions').on('click', moreOptions);

    $('#submit').on('click', function (){
        $('#appointmentForm').validate({
            rules: {0: {required: true, date: true}, 1: {required: true, date: true}}, //checks that at least one start and end date are submitted
            //we should write our own rule so that start is always earlier than end TODO
            submitHandler: submit,
        });
    });
}

function moreOptions(){
    options += 1;
    let option = "<input type=\"datetime-local\" id=\"" + options + "\" name=\"" + options + "\" class=\"form-control\">\n";
    $('#start').append(option);
    options += 1;
    option = "<input type=\"datetime-local\" id=\"" + options + "\" name=\"" + options + "\" class=\"form-control\">\n";
    $('#end').append(option);
}

function submit(){
    console.log("submitted");
    var dateOptions = [$('#0').val(), $('#1').val()];

    var i = 2;
    var id = "#" + i.toString();
    while($(id).length > 0) {
        id = "#" + i.toString();
        let j = i + 1;
        var nextId = '#' + j.toString();
        if((i % 2 == 0) && ($(id).val() != $(nextId).val())) {
            dateOptions.push($(id).val());
            dateOptions.push($(nextId).val());
        }
        i += 2;
        id = "#" + i.toString();
    }
    console.log(dateOptions);
    //TODO check if %2 == 0, else do something about it, like, delete last entry


    var name = $('#name').val();
    var description = $('#description').val();
    var creator = $('#creator').val();
    var method = "newAppointment";
    var param = "newAppointment";

    $.ajax({
        type: "POST",
        method: "POST",
        url: "../Backend/serviceHandler.php",
        data: { data : {
            name : name,
            description : description,
            creator : creator,
            method: method,
            param: param,
            dateoptions : dateOptions}
        },
        cache: false,
        dataType: "json",
        success: function (response) {
            console.log("ajax post success. response:")
            console.log(response);
            loadList();
                $('#newAppointment').slideUp(500, function () {
                $('#appointmentList').fadeIn(200);
            });
        },
        error: function(response){
            console.log("ajax post error. response:")
            console.log(response);
            let errormessage = "<p>" + response['status'] + " " + response['responseText'] + "</p>";
            alert(errormessage);
        }
    });
}

function submitPerson(){
    //console.log("success submitting person");
    var lastDate = $(":checkbox:last-of-type").attr("value");
    console.log(lastDate);
    //value
    var name = $("#person").val();
    var comment = $("#comment").val();
    var method = "newPeople";
    var param = "newPeople";

    $.ajax({
        type: "POST",
        method: "POST",
        url: "../Backend/serviceHandler.php",
        data: { data : {
                name: name,
                comment: comment,
                method: method,
                param: param}
        },
        cache: false,
        dataType: "json",
        success: function (response) {
            console.log("ajax post success. response:")
            console.log(response);
            loadList()
            $('#details').slideUp(500, function () {
                $('#appointmentList').fadeIn(200);
            });
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


//$(document).ready(function () { /*sortable in jquery ui library, hide placeholders so the numbering doesn't change during drag and drop*/
  /*
    $('ol').sortable({
        start: function( event, ui ){
            $(ui.item).parent().find('.ui-sortable-placeholder').hide();
        },
    });
});
   */


$(document).ready(
    $('#add').on("click", addItem),
    $('#visibility').on("click", toggleList),
    $('#edit').on("click", editList),
    $('#newAppointment').hide(),
    $('#details').hide(),
    loadList()
);
