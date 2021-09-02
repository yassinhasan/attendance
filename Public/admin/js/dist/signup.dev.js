"use strict";

var form = document.querySelector(".form"),
    url = form.getAttribute("action"),
    submitbtn = document.querySelector(".btn-submit");

form.onsubmit = function (e) {
  e.preventDefault();
};

submitbtn.addEventListener("click", function (e) {
  var formdata = new FormData(form);
  fetch(url, {
    method: 'POST',
    body: formdata
  }).then(function (resp) {
    return resp.json();
  }).then(function (data) {
    removeError(document.querySelectorAll(".result"));

    if (data.error) {
      var er = data.error;

      for (el in er) {
        if (el) {
          showError(document.querySelector(".".concat(el)), er[el]);
        }
      }
    }

    if (data.suc) {
      success();
    }

    if (data.db_error) {
      console.log(db_error);
    }
  });
});

function showError(el, msg) {
  el.classList.add("invalid-feedback");
  el.innerHTML = msg;
}

function removeError(el) {
  el.forEach(function (element) {
    element.classList.remove("invalid-feedback");
    element.innerHTML = "";
  });
}

function success(data) {
  Swal.fire({
    title: 'success',
    text: 'We Send Email For Verfiication ',
    icon: 'success',
    confirmButtonText: 'Cool'
  });
}