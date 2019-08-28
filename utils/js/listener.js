$("document").ready(function() {
  $("#button").click(function() {
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
  channel.bind("chat", function(data) {
    console.log(data);
    const chat = data[0];
    const className = data[1];
    $("#screen").append(
      `<div class="${className} message">
          <div class="row w-100 d-flex justify-content-between p-2 m-0">
            <span><b>${chat.username}</b></span>
            <span>${chat.time.slice(0, 5)}</span>
          </div>
          <p class="p-2">${chat.message}</p>
        </div>`
    );

    scrollDown("#screen", 100);
  });
});
