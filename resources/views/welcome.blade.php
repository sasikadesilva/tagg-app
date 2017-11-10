<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TagPost</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>

<table>
    <tr>
        <td>Post Title</td>
        <td><input type="text" id="postTitle" name="postTitle"> </td>

    </tr>
    <tr>
        <td>Post Message</td>
        <td><input type="text" id="postMessage" name="postMessage"> </td>

    </tr>
    <tr>
        <td>Post Tage</td>
        <td><div class="bootstrap-tagsinput focus"></div> <input type="text" id="tags"  name="tags"  data-role="tagsinput" /></div> </td>

    </tr>
    <tr>
        <td align="right"><input type="submit" value="Submit"  id="ok"  ></td>


    </tr>
</table>
<table>
    <tr>
        <td>Enter Tag name:</td>
        <td><input type="text" id="search"><input type="submit" id="searchbtn"> </td>
    </tr>
    <tbody id="content">

    </tbody>
    <div id="tablefoot" align="center" ></div>
</table>


<div id="showData" align="center"></div>




<script src="{{asset('/js/app.js')}}"></script>


<script type="text/javascript">

    var viewPath;
    $("#searchbtn").click(function(){
        $.ajax({

            method: "GET",
            url: "/search",
            data: {tagname:$("#search").val()},
            dataType: 'json',

            success: function(msg) {
                window.alert("ok");

            }

        })
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

$("#ok").click(function() {

var tagsset = {title:$('#postTitle').val(),message:$('#postMessage').val(),tags:$('#tags').tagsinput('items')};
console.log(tagsset);
    $.ajax({

        method: "POST",
        url: "/a",
        data: tagsset,
        dataType: 'json',

        success: function(msg) {
            console.log(msg);
            viewPath = "/select?page=";
            select(1);
        }

    })





});
    viewPath = "/select?page=";
    select(1)
function select(pageNumber) {

    $.get(viewPath+pageNumber, function (data) {


        var first = 1;
        var page="";
        for (var i = first; i <= data.last_page; i++) {

            if(i == data.current_page){
                page += "<li class='page-item'><button class='active  page-link btn-primary' onClick='select(" + i + ");'>" + i + "</button></li>";
            }
            else{
                page += "<li class='page-item'><button  class='page-link btn-primary' onClick='select(" + i + ");'>" + i + "</button></li>";
            }

            $("#content").html("");
        }

        $("#tablefoot").html("<nav aria-label='Page navigation example'><ul class='pagination'>" + page + "</ul></nav>");
        console.log(data);

        $.each(data.data, function (key1, value) {

            var selectDataSet = $(
                "<tr>" +
                "<td><h1><b>" + value['id'] + "</td>" +
                "<td><h1><b>" + value['title'] + "</td>" +
                "</tr>"+
                "<tr>"+
                     "<td id='tagset"+value['id']+"'>"+


                     "</td>"+
                "</tr>"

            );

            selectDataSet.appendTo("#content");
                    $.each(value['tags'], function (key2, value2) {
                    var postTags = $(

                            "<ul>"+
                            "<li>"+value2['tagName']+"</li>"+
                            "</ul>"

                        );
                        postTags.appendTo("#tagset"+value['id']);
                    });




          console.log(selectDataSet);




        });


    });
}


</script>

</body>
</html>

