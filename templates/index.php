<!DOCTYPE html>
<html>
<head>
<title class="ch_main-title">Chameleon</title>

  <script src="https://cdn.jsdelivr.net/npm/opensheetmusicdisplay@1.8.4/build/opensheetmusicdisplay.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@magenta/music@1.23.1/dist/magentamusic.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/static/css/main.css"> 
  <link rel="stylesheet" type="text/css" href="/static/css/navbar_2.css"> 
  <link rel="stylesheet" type="text/css" href="/static/css/vertical-accordion.css"> 
  <script src="/static/js/navbar_2.js"></script>

  <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js "></script>
  <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css " rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&amp;display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="images/chameleon-favicon.png">

  <script src="https://polyfill.io/v3/polyfill.min.js?features=Array.from,Array.prototype.find"></script>


</head>
<body>

{% include 'navbar_2.php' %}

<section>
  <details open class="ch_insert-detail">
    <summary>Insert your Melody</summary>
    <div class="ch_insert-melody-div">       
      <!-- <h1 class="ch_insert-melody-header">Insert your Melody</h1>
      <p class="ch_insert-melody-instructions-p">You can browse for a .mxl file you want to upload. This will be the melody</p>
      <button class="ch_browse-file-button">Browse File</button>  -->
      <h1>File Upload</h1>

      <div id="drop-area" class="drop-area">
          <p>Drag and drop a file here or click to select a file.</p>
          <input type="file" id="fileInput" style="display: none;" accept=".musicxml">
      </div>
    </div>
  </details>
  <details>
    <summary>Annotate</summary>
    <div class="ch_insert-chords-div">       
      <!-- <h1 class="ch_insert-chords-header">Enter the position of the chords in the melody</h1>
      <p class="ch_insert-chords-instructions-p">BLAH BLAH BLAH</p> -->
      
      <button class="ch_test-button">Harmonise</button>
    </div>
  </details>
  <details>
    <summary>Chord Suggestion</summary>
    <div class="ch_reply-div">           
      <h1 class="ch_reply-main-header">Reply ?</h1> <!-- double class // class="ch_reply-main-heading blah_blah"-->
      <p class="ch_reply-p">verovio? or other response and display</p>
      <div id="osmdContainer-2"></div>
    </div>
  </details>
</section>

<div id="osmdContainer"></div>


<!-- <div class="ch_main-div">
  <div class="ch_insert-melody-div">       
      <h1 class="ch_insert-melody-header">Insert your Melody</h1>
      <p class="ch_insert-melody-instructions-p">You can browse for a .mxl file you want to upload. This will be the melody</p>
      <button class="ch_browse-file-button">Browse File</button> 
  </div>
  <div class="ch_insert-chords-div">       
      <h1 class="ch_insert-chords-header">Enter the position of the chords in the melody</h1>
      <p class="ch_insert-chords-instructions-p">BLAH BLAH BLAH</p>
      <div id="osmdContainer"></div>
      <button class="ch_test-button">test</button>
  </div>
  <div class="ch_reply-div">           
      <h1 class="ch_reply-main-header">Reply ?</h1> 
      <p class="ch_reply-p">verovio? or other response and display</p>
      <div id="osmdContainer-2"></div>
  </div>
</div> -->



<!-- <div class="arrayrender">
  <div id="note_salience" class="">Note Saliene:</div>
  <div id="chord_position" class="">Chord Position:</div>
</div> -->
<form id="my-form">
  <!-- other form fields -->
  <input type="hidden" name="counts" id="counts-input">
  <input type="hidden" name="arrowstates" id="arrowstates-input">
  <button type="submit">Download final xml</button>
</form>



<!-- <script>
  var filename = "";
  var osmd = new opensheetmusicdisplay.OpenSheetMusicDisplay("osmdContainer", {autoResize: false});
  osmd.setOptions({
    backend: "svg",
    drawTitle: true,
    autoResize: false
    // drawingParameters: "compacttight" // don't display title, composer etc., smaller margins
  });
  osmd
    .load("static/xml/original_name_step2.musicxml")
    .then(
      function() {
        osmd.render();
      }
    ).then(function() {

      // for (let i=0; i < osmd.sheet.MusicPartManager.MusicSheet.musicPartManager.MusicSheet.musicPartManager.musicSheet.sourceMeasures.length; i++) {
      //   for (let y = 0; y < osmd.sheet.MusicPartManager.MusicSheet.sourceMeasures[i].verticalMeasureList[0].staffEntries.length; y++) {
      //     if (osmd.sheet.MusicPartManager.MusicSheet.sourceMeasures[i].verticalMeasureList[0].staffEntries[y].sourceStaffEntry.voiceEntries[0].notes[0].halfTone == 0) {
      //       console.log("pause")
      //     }
      //   }
        
      // }
      var ourselections = document.getElementsByClassName("vf-notehead");
      var redElements = [];
      var redElementsX = [];
      var redElementsY = [];

      for (var i = 0; i < ourselections.length; i++) {
          var element = ourselections[i].children;
          var fillAttribute = element[0].getAttribute("fill");

          //console.log(fillAttribute);

          if (fillAttribute === "#FF0000") {
              //console.log(element[0].parentNode.parentNode)
              element[0].parentNode.parentNode.style.display = "none"
              redElements.push(element); // Append the element to the list
              //console.log(ourselections[i].querySelector('path'));
              redElementsX.push(ourselections[i].querySelector('path').getBBox().x);
              redElementsY.push(ourselections[i].querySelector('path').getBBox().y);
              // Create a circle element
              var circleElement = document.createElementNS("http://www.w3.org/2000/svg", "circle");
              circleElement.setAttribute("r", "5");
              circleElement.setAttribute("fill", "#bbbbbb"); // Adjust the fill color as needed
              circleElement.setAttribute("class", "chordPosition")
              // Set the position of the circle based on the child element's position
              circleElement.setAttribute("cx", ourselections[i].querySelector('path').getBBox().x);
              circleElement.setAttribute("cy", ourselections[i].querySelector('path').getBBox().y);

              // Append the circle to the SVG
              document.querySelector('svg').appendChild(circleElement);
          }
      }

      console.log("redElementsX: ", redElementsX);
      console.log("redElementsY: ", redElementsY);
      

      // redElements now contains all elements with fill attribute #FF0000
      //console.log(redElements);
    });
      //console.log(osmd.sheet.MusicPartManager.MusicSheet.sourceMeasures[1].verticalMeasureList[0].staffEntries[4].sourceStaffEntry.voiceEntries[0].notes[0].halfTone)
      // let notes = document.getElementsByClassName("vf-notehead");


      // for (let i = 0; i < notes.length; i++) {
      //   notes[i].addEventListener("mouseenter", function() {
      //   notes[i].firstElementChild.setAttribute("fill", "red");
      //   });
      //   notes[i].addEventListener("mouseleave", function() {
      //   notes[i].firstElementChild.setAttribute("fill", "black");
      //   });
      //   //notes[i].addEventListener("click", createTooltip);
      // }
      // const arrowStatesInput = document.getElementById('arrowstates-input');
      // const countsInput = document.getElementById('counts-input');

      // const noteheads = document.querySelectorAll('.vf-notehead');
      // const svgNS = 'http://www.w3.org/2000/svg';
      // const arrowStates = new Array(noteheads.length).fill(false);

      // const togglePurpleArrow = (notehead, index) => {
      //   const arrow = notehead.querySelector('.purple-arrow');

      //   if (arrow) {
      //     arrow.remove();
      //     arrowStates[index] = false;
      //   } else {
      //     const rect = notehead.getBoundingClientRect();
      //     const arrowX = rect.left + rect.width - 25 / 2;
      //     const arrowY = rect.top - 20;

      //     const arrowPath = document.createElementNS(svgNS, 'path');
      //     arrowPath.setAttribute('d', `M ${arrowX} ${arrowY} L ${arrowX - 5} ${arrowY - 10} L ${arrowX + 5} ${arrowY - 10} Z`);
      //     arrowPath.setAttribute('fill', '#0F7B7B');
      //     arrowPath.setAttribute('class', 'purple-arrow');
      //     notehead.appendChild(arrowPath);
      //     arrowStates[index] = true;
      //   }
      // };

      // noteheads.forEach((notehead, index) => {
      //   notehead.addEventListener('click', () => {
      //     if (event.shiftKey) {
      //       togglePurpleArrow(notehead, index);
      //       document.getElementById("chord_position").innerHTML = "Chord Position:" + arrowStates
      //       arrowStatesInput.value = JSON.stringify(counts)
      //       console.log(arrowStates)
      //     }
      //   });
      // });

      // const counts = new Array(noteheads.length).fill(0); // initialize the counts array with zeros
      // const countEls = [];

      // noteheads.forEach((notehead, index) => {
      //   const countEl = document.createElementNS("http://www.w3.org/2000/svg", "text");
      //   countEl.setAttribute("x", "50%");
      //   countEl.setAttribute("y", "100%");
      //   countEl.setAttribute("text-anchor", "middle");
      //   countEl.setAttribute("font-size", "12px");
      //   countEl.setAttribute("fill", "red");
      //   countEl.textContent = counts[index]; // set the text content to the initial count

      //   const noteheadBBox = notehead.getBBox();
      //   const noteheadCenterX = noteheadBBox.x + noteheadBBox.width / 2;
      //   const noteheadBottomY = noteheadBBox.y + noteheadBBox.height;
      //   const svg = notehead.closest('svg');
      //   svg.appendChild(countEl);

      //   countEl.setAttribute("x", noteheadCenterX);
      //   countEl.setAttribute("y", noteheadBottomY + 15);

      //   notehead.addEventListener('click', (event) => {
      //     if (event.metaKey || event.ctrlKey) { // cmd/ctrl key pressed
      //       counts[index]++;
      //       countEl.textContent = counts[index];
      //       //console.log(counts)
      //       document.getElementById("note_salience").innerHTML = "Note Saliene:" + counts
      //       countsInput.value = JSON.stringify(counts)
      //     } else if (event.shiftKey) { // shift key pressed
      //       // do something else
      //     }
      //   });
      //   countEls.push(countEl);
      // });


      // window.addEventListener("resize", () => {
      // countEls.forEach((countEl, index) => {
      //   const notehead = noteheads[index];
      //   const noteheadBBox = notehead.getBBox();
      //   const noteheadCenterX = noteheadBBox.x + noteheadBBox.width / 2;
      //   const noteheadBottomY = noteheadBBox.y + noteheadBBox.height;

      //   countEl.setAttribute("x", noteheadCenterX);
      //   countEl.setAttribute("y", noteheadBottomY + 15);
      //   });
      // });
      // const form = document.getElementById('my-form');
      // form.addEventListener('submit', handleSubmit);

      // function handleSubmit(event) {
      //   event.preventDefault();
        
        
      //   console.log(arrowStatesInput.value)
      //   const counts = JSON.parse(countsInput.value);
      //   const arrowStates = JSON.parse(arrowStatesInput.value);
        
      //   fetch('/my-flask-endpoint', {
      //     method: 'POST',
      //     headers: {
      //       'Content-Type': 'application/json'
      //     },
      //     body: JSON.stringify({
      //       counts: counts,
      //       arrowStates: arrowStates
      //     })
      //   })
      //   .then(response => response.json())
      //   .then(data => console.log(data))
      //   .catch(error => console.error(error));
      // }
          
      //     });

  

</script> -->
<script src="/static/js/main.js"></script> 
</body>
</html>
