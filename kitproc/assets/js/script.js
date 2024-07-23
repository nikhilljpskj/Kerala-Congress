var loader = document.querySelector("#loader-back");
// Loader at start
$(document).ready(function () {
  $("#loader").hide();
});

$("document").ready(function () {
  $("#formReg1").on("submit", function (evt) {
    evt.preventDefault();
    if ($("#formReg1").valid()) {
      let data = $("#formReg1").serialize();
      $("#loader").show();
      $.ajax({
        url: "/register/1",
        method: "POST",
        data: data,
        success: () => {
          window.location.replace("/register/2");
          $("#loader").hide();
        },
      });
    }
  });
  $("#formReg2").on("submit", function (evt) {
    evt.preventDefault();
    if ($("#formReg2").valid()) {
      let data = $("#formReg2").serialize();
      $("#loader").show();
      $.ajax({
        url: "/register/2",
        method: "POST",
        data: data,
        success: (response) => {
          window.location.replace("/register/3");
          $("#loader").hide();
        },
      });
    }
  });
  $("#district").on("change", function (evt) {
    evt.preventDefault();
    var district = $(this).val();
    if (district) {
      $.ajax({
        url: "/load-assemblies?district=" + district,
        method: "GET",
        success: (response) => {
          $("#assembly")
            .find("option")
            .remove()
            .end()
            .append('<option value="" selected disabled >Select</option>')
            .val("whatever");
          for (var i in response) {
            var option = document.createElement("option");
            option.value = response[i].lacname;
            option.innerHTML = response[i].lacname;
            document.querySelector("#assembly").options.add(option);
          }
          document.querySelector("#assembly").selectedIndex = 0;
        },
      });
    } else {
      $("#assembly")
        .find("option")
        .remove()
        .end()
        .append('<option value="" selected>Select</option>')
        .val("whatever");
      document.querySelector("#assembly").selectedIndex = 0;
    }
  });
  $("#assembly").on("change", function (event) {
    event.preventDefault();
    var assemblyName = $(this).val();
    if (assemblyName) {
      $.ajax({
        url: "/load-localbodies?assembly=" + assemblyName,
        method: "GET",
        success: (response) => {
          // console.log(response)
          $("#lgs")
            .find("option")
            .remove()
            .end()
            .append('<option value="" selected>Select</option>')
            .val("whatever");

          for (var i in response) {
            var option = document.createElement("option");
            option.value = response[i];
            option.innerHTML = response[i];
            document.querySelector("#lgs").options.add(option);
          }
          document.querySelector("#lgs").selectedIndex = 0;
        },
      });
    } else {
      $("#lgs")
        .find("option")
        .remove()
        .end()
        .append('<option value="" selected>Select</option>')
        .val("whatever");
      document.querySelector("#lgs").selectedIndex = 0;
    }
  });
  $("#formReg3").on("submit", function (event) {
    event.preventDefault();
    data = $("#formReg3").serialize();
    $.ajax({
      url: "/register/3",
      data: data,
      method: "POST",
      success: (response) => {
        console.log(response);
        if (response) {
          $("#registerNumber").html(response.id);
          $("#alertMemberId").modal("show");
        }
      },
    });
  });
  $("#formAdminLogin").on("submit", function (evt) {
    evt.preventDefault();
    let data = $(this).serialize();
    $.ajax({
      url: "/admin/login",
      data: data,
      method: "post",
      success: (response) => {
        window.location.replace("/admin/home");
      },
      error: (error) => {
        console.log(error.responseJSON);
        $("#modalAlertTitle").html("Error").addClass("text-danger");
        $("#modalAlertMessage").html(error.responseJSON.message);
        $("#modalAlert").modal("show");
      },
    });
  });
  document
    .querySelector("#formUploadNews")
    .addEventListener("submit", function (evt) {
      evt.preventDefault();
      var formData = new FormData(document.querySelector("#formUploadNews"));
      // var content = $("#summernote").summernote("code");
      $.ajax({
        url: "/admin/news/create",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: (response) => {
          console.log(response);
          if (response.status) {
            alert(response.message);
            window.location.replace("/admin/news-dashboard");
          }
        },
        error: (error) => {
          console.log(error);
          alert(error.responseJSON.message);
        },
      });
    });
});
