const socket = new WebSocket("ws://localhost:8001/ws");

socket.onopen = () => {
  console.log("WebSocket opened");
  socket.send("Hello Server!");
};

socket.onmessage = (event) => {
  console.log("Message from server:", event.data);
};

socket.onerror = (event) => {
  console.log("WebSocket error:", event);
};

socket.onclose = () => {
  console.log("WebSocket closed");
};
// socket.on("message", (event) => {
//   console.log("Message from server:", event.data);
// }
// socket.on("error", (event) => {
//   console.log("WebSocket error:", event);
// });