var baseUrl = window.location.origin;

$(document).ready(function ($) {
    const scontrol = $("#in-home-search");

    $.ajax({
        type: "GET",
        url: `${baseUrl}/home/search`,
        dataType: "json",
        cache: false
    }).done(function (response) {
        setInterval(render(response.data), 2000);
    }).fail(function (xhr, textStatus, errorThrown) {
    });

    scontrol.keyup(function () {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/home/search/${$(this).val()}`,
            dataType: "json",
            cache: false
        }).done(function (response) {
            setInterval(render(response.data), 2000);
        }).fail(function (xhr, textStatus, errorThrown) {
        });
    });
});

function render(data, textStatus) {

    $('#quizzes-wrapper').empty();

    if (Array.isArray(data)) {
        data.forEach(quiz => {
            $(`<div class="_c_ card col-sm-3">
            <div class="wrapper">
                <h3 class="title">${quiz.title}</h3>
                <div class="data">
                    <div class="content">
                        <p class="text">
                            <span class="p-3 mb-3">${quiz.summary}</span>
                            <a class="btn btn-primary w-100" href="${baseUrl}/start/${quiz.id}">Start<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>`).appendTo($('#quizzes-wrapper'));
        });
    }
}
