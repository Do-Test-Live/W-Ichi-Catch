// Function to detect if the user is browsing from a desktop device
/*function isDesktop() {
    const userAgent = navigator.userAgent;
    return !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent));
}

// Function to show an alert for desktop users
function showAlertForDesktop() {
    alert('Sorry, this website is not accessible from desktop devices. Please visit from a mobile device.');
    window.location.replace("https://www.google.com/");
}

// Check if the user is browsing from a desktop device and show the alert
if (isDesktop()) {
    showAlertForDesktop();
}*/


var dom = document.getElementById("chart");
var myChart = echarts.init(dom);
var app = {};
option = null;

option = {
    title: {
        text: '',
        left: ''
    },
    series: [{
        type: 'gauge',
        startAngle: 180,
        endAngle: 0,
        progress: {
            show: false,
            width: 10
        },
        axisLine: {
            roundCap: true,
            lineStyle: {
                width: 10,
                color: [
                    [0.20, '#7f60fe'],
                    [1, '#ffffff'],
                ]
            }
        },
        axisTick: {
            show: false
        },
        splitLine: {
            length: 15,
            lineStyle: {
                width: 0,
                color: '#999'
            }
        },
        axisLabel: {
            show: false,
            distance: 5,
            color: '#999',
            fontSize: 14
        },
        pointer: {
            icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
            length: '0',
            width: 1,
            offsetCenter: [0, '0']
        },
        anchor: {
            show: false,
            showAbove: true,
            size: 10,
            itemStyle: {
                borderWidth: 3
            }
        },
        detail: {
            show: true,
            valueAnimation: true,
            fontSize: 40,
            color: '#ffffff',
            offsetCenter: [0, '20%']
        },
        data: [{
            value: 20
        }]
    }]
};

if (option && typeof option === "object") {
    myChart.setOption(option, true);
}