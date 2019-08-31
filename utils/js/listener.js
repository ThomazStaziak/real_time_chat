$("document").ready(function() {
  $("#form").submit(function(evt) {
    evt.preventDefault();
    const username = $("#username").val();
    const message = $("#message").val();

    if (username == "" || message == "") return;

    $("#message").val("");

    $.ajax({
      url: "utils/php/trigger.php",
      method: "post",
      dataType: "json",
      data: {
        username,
        message
      }
    });
  });

  Pusher.logToConsole = true;

  const pusher = new Pusher("2fb071cffdac6f3ff0d7", {
    cluster: "us2",
    forceTLS: true
  });

  const channel = pusher.subscribe("channel");
  channel.bind("chat", data => {
    console.log(data);
    const loggedUser = getCookie("username");
    const chat = data[0];
    const messageSender = data[1];

    console.log(loggedUser, messageSender);

    $("#screen").append(
      `
        <li style="width:100%">
          <div class="${
            loggedUser === messageSender ? "msj-rta" : "msj"
          } macro">
            <div class="text ${
              loggedUser === messageSender ? "text-l" : "text-r"
            }">
            ${
              loggedUser != messageSender
                ? `<p class='user font-weight-bold'>${chat.username}</p>`
                : ""
            }
              <p class="message">${chat.message}</p>
              <p class="time"><small>${chat.time.slice(0, 5)}</small></p>
            </div>
          </div>
        </li>
      `
    );

    scrollDown("#screen", 100);
  });

  channel.bind("userAction", data => {
    const loggedUser = getCookie("username");
    console.log(data, loggedUser);
    let html = "";
    data.forEach(user => {
      if (loggedUser != user.username)
        html += `<p class="text-success">${user.username}</p>`;
    });
    $(".users").html(html);
  });
});
