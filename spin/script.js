var data = ['Ipad', 'Ipad', 'Gift 1', 'Gift 2', 'Gift 3', 'Gift 4', 'Gift 5', 'Gift 6', 'Gift 7', 'Gift 8'];
var selectedDataValue; // Variable to store selected data value
const slices = document.getElementsByClassName('square'); // Remove the dot before 'square'

for (i = 0; i < data.length; i++) {
    $(".square:nth-child(" + i + ") .textArea:nth-child(2)").text(data[i]);
}

var timer = null;
playbutton.onclick = playRandom;

function playRandom() {
    var drawTitle = document.getElementById('drawTitle');
    drawTitle.innerHTML = "Wait Untill it stops. Then try again";
    var playbutton = document.getElementById('playbutton');
    clearInterval(timer);

    timer = setInterval(function () {
        let totalProbability = 0;

        // Use a traditional for loop to iterate through the HTMLCollection
        for (let i = 0; i < slices.length; i++) {
            const probability = parseFloat(slices[i].getAttribute('data-probability'));
            totalProbability += probability;
        }

        const random = Math.random() * totalProbability;
        let accumulatedProbability = 0;
        let selectedIndex = -1;

        // Find the selected index based on the accumulated probability
        for (let i = 0; i < slices.length; i++) {
            const probability = parseFloat(slices[i].getAttribute('data-probability'));
            accumulatedProbability += probability;
            if (random <= accumulatedProbability) {
                selectedIndex = i;
                break;
            }
        }

        selectedDataValue = data[selectedIndex + 1]; // Store selected data value
        $(".square:nth-child(" + (selectedIndex + 1) + ")").css("background", "rgba(25,115,255,1)");
        $(".square:not(:nth-child(" + (selectedIndex + 1) + "))").css("background", "rgba(0,40,241,0.5)");
    }, 30);

    playbutton.style.background = '#666';

    // Automatically stop after 5 seconds
    setTimeout(function () {
        stopFun();
    }, 5000);
}

function stopFun() {
    clearInterval(timer);
    var playbutton = document.getElementById('playbutton');
    playbutton.style.background = '#036';
    console.log(selectedDataValue); // Alert the selected data value
}
