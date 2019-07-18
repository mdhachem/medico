var baseUrl = window.location.origin;
const wizard = $("#questions-wizard");

$(document).ready(function($) {
  var jInputViewRef = $("#justifying-input-1");
  var quizid = window.location.pathname.split("/")[2];
  var selected_value = "";
  var controlValue = null;
  var data = [];

  wizard.steps({
    headerTag: "h4",
    bodyTag: "section",
    transitionEffect: "slide",
    titleTemplate: "#title#",
    autoFocus: true,
    onInit: function(event, current) {
      jInputViewRef = $("#justifying-input-1");
      $(".actions > ul > li:first-child").attr("style", "display:none");
    },
    onStepChanging: function(e, currentIndex, newIndex) {
      $(`#justifying-input-${currentIndex + 1} .invalid-feedback`).remove();

      if (selected_value === "") return false;

      if (
        (selected_value.split("-")[0] === "no" ||
          selected_value.split("-")[0] === "na") &&
        controlValue === null
      ) {
        jInputViewRef.append(
          `<div class="invalid-feedback d-block">Please fill the justification field</div>`
        );
        return false;
      }

      if (currentIndex > newIndex) return false;

      return true;
    },
    onStepChanged: function(event, currentIndex, priorIndex) {
      controlValue = null;

      jInputViewRef = $(`#justifying-input-${currentIndex + 1}`);
      data.push({
        id: selected_value.split("-")[1],
        body: selected_value.split("-")[0],
        justification: controlValue
      });
      selected_value = "";
    },
    onFinishing: function(event, currentIndex) {
      $(`#justifying-input-${currentIndex + 1} .invalid-feedback`).remove();

      if (selected_value === "") return false;

      if (
        (selected_value.split("-")[0] === "no" ||
          selected_value.split("-")[0] === "na") &&
        controlValue === null
      ) {
        jInputViewRef.append(
          `<div class="invalid-feedback d-block">Please fill the justification field</div>`
        );
        return false;
      } else {
        data.push({
          id: selected_value.split("-")[1],
          body: selected_value.split("-")[0],
          justification: controlValue
        });
        $.ajax({
          type: "POST",
          contentType: "application/json",
          url: `${baseUrl}/answer/${quizid}`,
          data: JSON.stringify(data),
          dataType: "json",
          success: function(response) {
            //TODO:: window.location.href = ${redirection URL}
            if (response.map(a => a.body).includes("no")) {
              window.location.href = `${baseUrl}/home/annexe/annexe1b/${quizid}`;
              console.log("There are at least one no");
            } else {
              window.location.href = `${baseUrl}/home/annexe/annexe1a/${quizid}`;
              console.log("think you");
            }
          }
        });
      }
    },
    labels: {
      finish: 'Finish <i class="fa fa-check"></i>',
      next: 'Next <i class="fa fa-chevron-right"></i>'
    }
  });

  $("#questions-wizard .btn-group-toggle").button("toggle");
  $("#questions-wizard .btn-group-toggle").change(function() {
    jInputViewRef.empty();

    selected_value = $("input[name=answer-radio]:checked").val();
    if (
      selected_value.split("-")[0] === "na" ||
      selected_value.split("-")[0] === "no"
    ) {
      jInputViewRef.append(`
                        <label>Justification</label>
                        <textarea class="form-control" id="j-text"></textarea>
                        `);

      $(".form-group .form-control").on("input", function() {
        controlValue = $(this).val() === "" ? null : $(this).val();
      });
    }
  });
});
