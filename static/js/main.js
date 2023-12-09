// const browseButton = document.getElementsByClassName("ch_browse-file-button")[0];

// browseButton.addEventListener("click", function() {
//     const fileInput = document.createElement("input");
//     fileInput.type = "file";
//     fileInput.accept = ".mxl"; // only mxl files are accepted

//     fileInput.click();

//     fileInput.addEventListener("change", function() {
//         const selectedFile = fileInput.files[0];

//         if (selectedFile) {
//             if (selectedFile.name.toLowerCase().endsWith(".mxl")) {

//                 Swal.fire({
//                     position: 'center',
//                     icon: 'success',
//                     title: 'You uploaded the file',
//                     showConfirmButton: false,
//                     timer: 2000
//                 });
//             } else {
//                 Swal.fire({
//                     position: 'center',
//                     icon: 'error',
//                     title: 'Invalid file selected. Please choose an MXL file.',
//                     showConfirmButton: false,
//                     timer: 3000
//                 });

//             }
//         } else {
//             Swal.fire({
//                 position: 'center',
//                 icon: 'question',
//                 title: 'No file selected.',
//                 showConfirmButton: false,
//                 timer: 1500
//             });
//         }
//     });
    
// });



// const testButton = document.getElementsByClassName("ch_test-button")[0];
// testButton.addEventListener("click", function() {
//     var osmd = new opensheetmusicdisplay.OpenSheetMusicDisplay("osmdContainer");
//     osmd.setOptions({
//     backend: "svg",
//     drawTitle: true,
//     });
//     osmd
//     .load("test.mxl")
//     .then(
//         function() {
//         osmd.render();
//         }
//   )
// });


var details = document.querySelector('.ch_insert-detail');
var dropArea = details.querySelector('#drop-area');

details.addEventListener('dragover', function (e) {
e.preventDefault();
if (e.target === dropArea) {
    dropArea.classList.remove('dragleave');
    dropArea.classList.add('dragover');
}
});

details.addEventListener('dragleave', function (e) {
if (e.target === dropArea) {
    dropArea.classList.remove('dragover');
    dropArea.classList.add('dragleave');
}
});

details.addEventListener('drop', function (e) {
e.preventDefault();
dropArea.style.border = '2px dashed #ccc';
var fileInput = document.getElementById('fileInput');
fileInput.files = e.dataTransfer.files;
handleFileUpload();
});

dropArea.addEventListener('click', function () {
document.getElementById('fileInput').click();
});

document.getElementById('fileInput').addEventListener('change', handleFileUpload);

function handleFileUpload() {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];
    if (file) {
        var fileExtension = file.name.split('.').pop().toLowerCase();
        if (fileExtension === 'musicxml') {
            // The file is of the correct format, you can submit the form or handle the upload.
            var formData = new FormData();
            formData.append('file', file);

            // Use fetch to send the file to the server
            fetch('/upload', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'File uploaded successfully') {
                    dropArea.classList.remove('error');
                    dropArea.classList.add('success');
                    dropArea.innerHTML = 'File uploaded successfully';

                    // Update filename
                    var filename = file.name.split(".")[0] + "_step2.musicxml";
                    loadSheetMusic(filename);
                } else {
                    dropArea.classList.remove('success');
                    dropArea.classList.add('error');
                    alert(result); // Display the server response
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('Invalid file format. Please upload a .musicxml file.');
            // Clear the file input
            fileInput.value = '';
        }
    }
}

function loadSheetMusic(filename) {
    var osmd = new opensheetmusicdisplay.OpenSheetMusicDisplay("osmdContainer", { autoResize: false });
    osmd.setOptions({
        backend: "svg",
        drawTitle: true,
        autoResize: false
    });

    // Use the updated filename dynamically
    osmd.load(`static/xml/${filename}`)
        .then(function () {
            osmd.render();
        })
        .then(function() {

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
                    circleElement.setAttribute("cx", ourselections[i].querySelector('path').getBBox().x + 5);
                    circleElement.setAttribute("cy", ourselections[i].querySelector('path').getBBox().y);
                    
                    var circleElement_2 = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                    circleElement_2.setAttribute("width", "10");
                    circleElement_2.setAttribute("height", "10");
                    circleElement_2.setAttribute("fill", "#bbbbbb"); // Adjust the fill color as needed
                    circleElement_2.setAttribute("class", "noteWeight")
                    // Set the position of the circle based on the child element's position
                    circleElement_2.setAttribute("x", ourselections[i].querySelector('path').getBBox().x);
                    circleElement_2.setAttribute("y", ourselections[i].querySelector('path').getBBox().y + 50);
                    // Append the circle to the SVG
                    document.querySelector('svg').appendChild(circleElement);
                    document.querySelector('svg').appendChild(circleElement_2);

                    
                }
            }

            var noteWeights = document.querySelectorAll('.noteWeight');
            console.log(noteWeights)
            noteWeights.forEach(function (noteWeight) {
                //console.log(noteWeight)
                noteWeight.addEventListener('click', function () {
                    // Stop the event from propagating to parent or child elements
                    // event.stopPropagation();
                    // console.log(this);
                    if (noteWeight.classList.contains('noteWeight_clicked')) {
                        noteWeight.classList.remove('noteWeight_clicked');
                    } else {
                        noteWeight.classList.add('noteWeight_clicked');
                    }
                });
            });

            var chordPositions = document.querySelectorAll('.chordPosition');

            chordPositions.forEach(function (chordPosition) {
                chordPosition.addEventListener('mouseover', function () {
                    chordPosition.setAttribute('r', (parseFloat(chordPosition.getAttribute('r')) + 0.12).toString());
                });

                chordPosition.addEventListener('mouseout', function () {
                    chordPosition.setAttribute('r', '5'); // Assuming the original radius is 20
                });

                chordPosition.addEventListener('click', function () {
                    if (chordPosition.classList.contains('chordPosition_clicked')) {
                        chordPosition.classList.remove('chordPosition_clicked');
                    } else {
                        chordPosition.classList.add('chordPosition_clicked');
                        chordPosition.setAttribute('r', (parseFloat(chordPosition.getAttribute('r')) - 0.12).toString());
                    }
                });
            });
      
            console.log("redElementsX: ", redElementsX);
            console.log("redElementsY: ", redElementsY);
            
      
            // redElements now contains all elements with fill attribute #FF0000
            //console.log(redElements);
          });
}