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
    e = $("#item").val();
    if(e == ""){
        return; /*i don't see the sense in making empty to-do items*/
    }
    $("ol").append("<li>" + e + "</li>");
    console.log("element added");
    $("#item").val(""); /*remove text from inputbox*/
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
    $("#visibility").on("click", toggleList),
    $("#edit").on("click", editList),
    loadList()
);
