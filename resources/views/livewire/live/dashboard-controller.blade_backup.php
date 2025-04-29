<div>
    {{-- Do your work, then step back. --}}
    <script>
    client = new WebSocket("ws://localhost:4040");

    client.onopen = (event) => {
      console.log(event);
    };


    client.onmessage = (event) => {
      console.log(event.data);
    //   const obj = JSON.parse(event.data);

    //   let myMap = new Map(Object.entries(obj));


    //   const anchors = document.querySelectorAll('a');


    //   anchors.forEach(anchor => {

    //     if (myMap[anchor.href] != null && myMap[anchor.href] > 2)
    //       anchor.style.color = "red";
    //     // console.log(anchor.value);

    //   })

      //console.log(myMap);
    };
  </script>

</div>
